<?php

use App\Models\Scholarship;
use App\Services\NotificationService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('notifications:scholarship-deadlines', function (NotificationService $notificationService) {
    $today = now()->toDateString();

    $scholarships = Scholarship::query()
        ->whereDate('end_date', $today)
        ->where('status', 'Disponível')
        ->get();

    foreach ($scholarships as $scholarship) {
        $notificationService->notifyStudents(
            'Último dia da bolsa',
            "Hoje é o último dia para candidatar-se à bolsa \"{$scholarship->name}\"."
        );
    }

    $this->info('Notificações de prazo processadas com sucesso.');
})->purpose('Notifica estudantes quando uma bolsa entra no último dia de candidatura');

Schedule::command('notifications:scholarship-deadlines')->dailyAt('07:00');
