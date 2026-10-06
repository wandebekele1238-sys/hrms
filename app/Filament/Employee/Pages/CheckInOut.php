<?php

namespace App\Filament\Employee\Pages;

use App\Models\Attendance;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class CheckInOut extends Page
{
    protected string $view = 'filament.employee.pages.check-in-out';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArrowPath;

    protected static string|UnitEnum|null $navigationGroup = 'Attendances Management';

    protected static ?string $navigationLabel = 'Check In / Out';

    public $todayAttendance = null;

    public bool $canCheckIn = false;

    public bool $canCheckOut = false;

    public string $currentTime = '';

    public function mount(): void
    {
        $this->loadAttendance();

        $this->currentTime = now()->format('H:i:s');
    }

    public function loadAttendance(): void
    {
        $this->todayAttendance = Attendance::query()
            ->where('user_id', auth()->id())
            ->whereDate('date', today())
            ->first();

        $now = now();

        /*
        |--------------------------------------------------------------------------
        | Attendance Time Windows
        |--------------------------------------------------------------------------
        |
        | Check In  : 07:30 AM - 08:15 AM
        | Check Out : 04:45 PM - 05:30 PM
        |
        */

        // Check-in window
        $checkInStart = today()->setTime(7, 30);
        $checkInEnd = today()->setTime(8, 15);

        // Check-out window
        $checkOutStart = today()->setTime(16, 45);
        $checkOutEnd = today()->setTime(17, 30);

        /*
        |--------------------------------------------------------------------------
        | Can Check In?
        |--------------------------------------------------------------------------
        */

        $this->canCheckIn =
            ! $this->todayAttendance &&
            $now->between($checkInStart, $checkInEnd);

        /*
        |--------------------------------------------------------------------------
        | Can Check Out?
        |--------------------------------------------------------------------------
        */

        $this->canCheckOut =
            $this->todayAttendance !== null &&
            $this->todayAttendance->check_in !== null &&
            $this->todayAttendance->check_out === null &&
            $now->between($checkOutStart, $checkOutEnd);
    }

    public function checkIn(): void
    {
        $this->loadAttendance();

        $now = now();

        /*
        |--------------------------------------------------------------------------
        | Check-in window
        |--------------------------------------------------------------------------
        */

        $checkInStart = today()->setTime(7, 30);
        $checkInEnd = today()->setTime(8, 15);

        /*
        |--------------------------------------------------------------------------
        | Already checked in
        |--------------------------------------------------------------------------
        */

        if ($this->todayAttendance) {
            Notification::make()
                ->title('Already Checked In')
                ->body('You have already checked in today.')
                ->warning()
                ->send();

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Check-in time validation
        |--------------------------------------------------------------------------
        */

        if (! $now->between($checkInStart, $checkInEnd)) {
            Notification::make()
                ->title('Check-In Not Available')
                ->body(
                    'Check-in is available only between 7:30 AM and 8:15 AM.'
                )
                ->danger()
                ->send();

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Create Attendance
        |--------------------------------------------------------------------------
        */

        try {
            Attendance::create([
                'user_id' => auth()->id(),
                'date' => today(),
                'check_in' => $now,
                'status' => 'present',
            ]);

            $this->loadAttendance();

            Notification::make()
                ->title('Checked In Successfully')
                ->body(
                    'Your check-in time: ' . $now->format('h:i A')
                )
                ->success()
                ->send();

        } catch (\Exception $e) {

            Notification::make()
                ->title('Check-In Failed')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function checkOut(): void
    {
        $this->loadAttendance();

        $now = now();

        /*
        |--------------------------------------------------------------------------
        | Check-out window
        |--------------------------------------------------------------------------
        */

        $checkOutStart = today()->setTime(16, 45);
        $checkOutEnd = today()->setTime(17, 30);

        /*
        |--------------------------------------------------------------------------
        | Must have checked in
        |--------------------------------------------------------------------------
        */

        if (! $this->todayAttendance) {
            Notification::make()
                ->title('Cannot Check Out')
                ->body('You must check in before checking out.')
                ->warning()
                ->send();

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Check-in must exist
        |--------------------------------------------------------------------------
        */

        if (! $this->todayAttendance->check_in) {
            Notification::make()
                ->title('Cannot Check Out')
                ->body('You must check in before checking out.')
                ->warning()
                ->send();

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Already checked out
        |--------------------------------------------------------------------------
        */

        if ($this->todayAttendance->check_out) {
            Notification::make()
                ->title('Already Checked Out')
                ->body('You have already checked out today.')
                ->warning()
                ->send();

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Check-out time validation
        |--------------------------------------------------------------------------
        */

        if (! $now->between($checkOutStart, $checkOutEnd)) {
            Notification::make()
                ->title('Check-Out Not Available')
                ->body(
                    'Check-out is available only between 4:45 PM and 5:30 PM.'
                )
                ->danger()
                ->send();

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Save Check-out
        |--------------------------------------------------------------------------
        */

        $this->todayAttendance->update([
            'check_out' => $now,
        ]);

        $this->loadAttendance();

        Notification::make()
            ->title('Checked Out Successfully')
            ->body(
                'Your check-out time: ' . $now->format('h:i A')
            )
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Check In Button
            |--------------------------------------------------------------------------
            */

            Action::make('checkIn')
                ->label('Check In')
                ->color('success')
                ->icon('heroicon-o-arrow-right-on-rectangle')
                ->visible(fn (): bool => $this->canCheckIn)
                ->requiresConfirmation()
                ->modalHeading('Check In')
                ->modalDescription(
                    'Check-in is available from 7:30 AM to 8:15 AM.'
                )
                ->modalSubmitActionLabel('Yes, Check In')
                ->action(fn () => $this->checkIn()),

            /*
            |--------------------------------------------------------------------------
            | Check Out Button
            |--------------------------------------------------------------------------
            */

            Action::make('checkOut')
                ->label('Check Out')
                ->color('danger')
                ->icon('heroicon-o-arrow-left-on-rectangle')
                ->visible(fn (): bool => $this->canCheckOut)
                ->requiresConfirmation()
                ->modalHeading('Check Out')
                ->modalDescription(
                    'Check-out is available from 4:45 PM to 5:30 PM.'
                )
                ->modalSubmitActionLabel('Yes, Check Out')
                ->action(fn () => $this->checkOut()),
        ];
    }
}