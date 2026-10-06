<?php

namespace App\Filament\Hr\Pages;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class Reports extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentChartBar;

    protected static ?string $navigationLabel = 'Reports';

    protected static ?string $title = 'HR Reports';

    protected static \UnitEnum|string|null $navigationGroup = 'Reports';

    protected string $view = 'filament.hr.pages.reports';

    public ?array $data = [];

    
public array $reportData = [];

public array $reportSummary = [
    'total' => 0,
    'present' => 0,
    'late' => 0,
    'absent' => 0,
    'attendance_rate' => 0,
];

public bool $reportGenerated = false;


    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('report_type')
                    ->label('Report Type')
                    ->options([
                        'attendance' => 'Attendance Report',
                        'leave' => 'Leave Report',
                        'employees' => 'Employee Report',
                        'payroll' => 'Payroll Report',
                        'performance' => 'Performance Report',
                    ])
                    ->default('attendance')
                    ->required(),

                DatePicker::make('from_date')
                    ->label('From Date')
                    ->default(now()->startOfMonth())
                    ->native(false)
                    ->required(),

                DatePicker::make('to_date')
                    ->label('To Date')
                    ->default(now())
                    ->native(false)
                    ->required(),

                
Select::make('department_id')
    ->label('Department')
    ->options(
        Department::query()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray()
    )
    ->searchable()
    ->preload()
    ->placeholder('All Departments')
    ->live()
    ->afterStateUpdated(function (callable $set): void {
        $set('employee_id', null);
    }),



                

Select::make('employee_id')
    ->label('Employee')
    ->options(function (Get $get): array {
        $departmentId = $get('department_id');

        $query = User::query()
            ->orderBy('name');

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        return $query
            ->pluck('name', 'id')
            ->toArray();
    })
    ->searchable()
    ->preload()
    ->placeholder('All Employees')
    ->live()
    ->helperText(function (Get $get): string {
        return $get('department_id')
            ? 'Showing employees from the selected department.'
            : 'Showing employees from all departments.';
    }),




            ])
            ->columns(5)
            ->statePath('data');
    }

public function mount(): void
{
    $this->form->fill([
        'report_type' => 'attendance',
        'from_date' => now()->startOfMonth()->format('Y-m-d'),
        'to_date' => now()->format('Y-m-d'),
        'department_id' => null,
        'employee_id' => null,
    ]);
}



    
public function generateReport(): void
{
    $this->validate();

    $query = Attendance::query()
        ->with('user')
        ->whereBetween('date', [
            $this->data['from_date'],
            $this->data['to_date'],
        ]);

    if (! empty($this->data['department_id'])) {
        $query->whereHas('user', function ($query) {
            $query->where(
                'department_id',
                $this->data['department_id']
            );
        });
    }

    if (! empty($this->data['employee_id'])) {
        $query->where(
            'user_id',
            $this->data['employee_id']
        );
    }

    $attendances = $query
        ->orderBy('date', 'desc')
        ->get();

    $total = $attendances->count();

    $present = $attendances
        ->where('status', 'present')
        ->count();

    $late = $attendances
        ->where('status', 'late')
        ->count();

    $absent = $attendances
        ->where('status', 'absent')
        ->count();

    $attendanceRate = $total > 0
        ? round((($present + $late) / $total) * 100, 1)
        : 0;

    $this->reportSummary = [
        'total' => $total,
        'present' => $present,
        'late' => $late,
        'absent' => $absent,
        'attendance_rate' => $attendanceRate,
    ];

    $this->reportData = $attendances
        ->map(function ($attendance) {
            return [
                'employee' => $attendance->user?->name ?? 'Unknown',
                'employee_id' => $attendance->user?->employee_id ?? '-',
                'date' => $attendance->date?->format('Y-m-d') ?? '-',
                'check_in' => $attendance->check_in?->format('H:i') ?? '-',
                'check_out' => $attendance->check_out?->format('H:i') ?? '-',
                'status' => $attendance->status ?? '-',
            ];
        })
        ->toArray();

    $this->reportGenerated = true;
}


}