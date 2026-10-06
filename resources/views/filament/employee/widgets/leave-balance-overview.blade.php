<x-filament-widgets::widget>
    <x-filament::section>

        {{-- ============================================================
             HEADER
        ============================================================ --}}
        <x-slot name="heading">
            Leave Balances
        </x-slot>

        <x-slot name="description">
            Your leave entitlement and current leave usage for {{ now()->year }}
        </x-slot>


        {{-- ============================================================
             LEAVE BALANCE TABLE
        ============================================================ --}}
        <div style="overflow-x:auto; margin-top:1.5rem;">

            <table style="
                width:100%;
                border-collapse:separate;
                border-spacing:0;
                font-size:0.95rem;
            ">

                {{-- ====================================================
                     TABLE HEADER
                ==================================================== --}}
                <thead>
                    <tr style="
                        background:#f8fafc;
                        border-bottom:2px solid #e5e7eb;
                    ">

                        <th style="
                            padding:1rem;
                            text-align:left;
                            font-weight:700;
                            color:#374151;
                            border-bottom:2px solid #e5e7eb;
                        ">
                            Leave Type
                        </th>

                        <th style="
                            padding:1rem;
                            text-align:center;
                            font-weight:700;
                            color:#374151;
                            border-bottom:2px solid #e5e7eb;
                        ">
                            Entitled
</th>

                        <th style="
                        
                            padding:1rem;
                            text-align:center;
                            font-weight:700;
                            color:#374151;
                            border-bottom:2px solid #e5e7eb;
                        ">
                            Used
                        </th>

                        <th style="
                            padding:1rem;
                            text-align:center;
                            font-weight:700;
                            color:#374151;
                            border-bottom:2px solid #e5e7eb;
                        ">
                            Pending
                        </th>

                        <th style="
                            padding:1rem;
                            text-align:center;
                            font-weight:700;
                            color:#374151;
                            border-bottom:2px solid #e5e7eb;
                        ">
                            Remaining
                        </th>

                    </tr>
                </thead>


                {{-- ====================================================
                     TABLE BODY
                ==================================================== --}}
                <tbody>

                    @forelse ($this->getLeaveBalances() as $balance)

                        <tr style="
                            border-bottom:1px solid #e5e7eb;
                            transition:background-color 0.2s ease;
                        ">

                            {{-- Leave Type --}}
                            <td style="
                                padding:1rem;
                                font-weight:600;
                                color:#111827;
                                background:#356775;
                            ">
                                <div style="
                                    display:flex;
                                    align-items:center;
                                    gap:0.75rem;
                                ">

                                    <div style="
                                        width:2.5rem;
                                        height:2.5rem;
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        border-radius:0.75rem;
                                        background:#eff6ff;
                                        color:#2563eb;
                                    ">
                                        <x-filament::icon
                                            icon="heroicon-o-calendar-days"
                                            style="width:1.25rem;height:1.25rem;"
                                        />
                                    </div>

                                    <span>
                                        {{ $balance['name'] }}
                                    </span>

                                </div>
                            </td>


                            {{-- Entitled --}}
                            <td style="
                                padding:1rem;
                                text-align:center;
                                background:#156321;
                            ">
                                <span style="
                                    display:inline-flex;
                                    align-items:center;
                                    justify-content:center;
                                    min-width:3rem;
                                    padding:0.4rem 0.75rem;
                                    border-radius:9999px;
                                    background:#eff6ff;
                                    color:#2563eb;
                                    font-weight:700;
                                ">
                                    {{ number_format($balance['entitled_days'], 0) }}
                                </span>
                            </td>


                            


                            {{-- Used --}}
                            <td style="
                                padding:1rem;
                                text-align:center;
                                background:#FF0000;
                            ">
                                <span style="
                                    display:inline-flex;
                                    align-items:center;
                                    justify-content:center;
                                    min-width:3rem;
                                    padding:0.4rem 0.75rem;
                                    border-radius:9999px;
                                    background:#fef2f2;
                                    color:#dc2626;
                                    font-weight:700;
                                ">
                                    {{ number_format($balance['used_days'], 0) }}
                                </span>
                            </td>


                            {{-- Pending --}}
                            <td style="
                                padding:1rem;
                                text-align:center;
                                background:#FFA500;
                            ">
                                <span style="
                                    display:inline-flex;
                                    align-items:center;
                                    justify-content:center;
                                    min-width:3rem;
                                    padding:0.4rem 0.75rem;
                                    border-radius:9999px;
                                    background:#fffbeb;
                                    color:#d97706;
                                    font-weight:700;
                                ">
                                    {{ number_format($balance['pending_days'], 0) }}
                                </span>
                            </td>


                            {{-- Remaining --}}
                            <td style="
                                padding:1rem;
                                text-align:center;
                                background:#7C3AED;
                            ">
                                <span style="
                                    display:inline-flex;
                                    align-items:center;
                                    justify-content:center;
                                    min-width:3.5rem;
                                    padding:0.5rem 0.9rem;
                                    border-radius:9999px;

                                    @if ($balance['remaining_days'] > 0)
                                        background:#ecfdf5;
                                        color:#059669;
                                    @else
                                        background:#fef2f2;
                                        color:#dc2626;
                                    @endif

                                    font-weight:800;
                                ">
                                    {{ number_format($balance['remaining_days'], 0) }}
                                </span>
                            </td>

                        </tr>

                    @empty

                        {{-- =================================================
                             EMPTY STATE
                        ================================================= --}}
                        <tr>
                            <td
                                colspan="6"
                                style="
                                    padding:3rem 1rem;
                                    text-align:center;
                                    color:#6b7280;
                                "
                            >

                                <div style="
                                    display:flex;
                                    flex-direction:column;
                                    align-items:center;
                                    justify-content:center;
                                    gap:0.75rem;
                                ">

                                    <x-filament::icon
                                        icon="heroicon-o-calendar-days"
                                        style="
                                            width:3rem;
                                            height:3rem;
                                            color:#9ca3af;
                                        "
                                    />

                                    <span style="
                                        font-size:1rem;
                                        font-weight:600;
                                    ">
                                        No leave types available.
                                    </span>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>


                {{-- ====================================================
                     TABLE FOOTER
                ==================================================== --}}
                @if ($this->getLeaveBalances()->count() > 0)

                    <tfoot>

                        <tr style="
                            background:#f8fafc;
                        ">

                            <td style="
                                padding:1rem;
                                font-weight:700;
                                color:#374151;
                            ">
                                Total Leave Types:
                                {{ $this->getLeaveBalances()->count() }}
                            </td>

                            <td colspan="4"></td>

                            <td style="
                                padding:1rem;
                                text-align:center;
                            ">

                                <span style="
                                    display:inline-flex;
                                    align-items:center;
                                    gap:0.4rem;
                                    padding:0.5rem 0.9rem;
                                    border-radius:9999px;
                                    background:#ecfdf5;
                                    color:#059669;
                                    font-weight:800;
                                ">

                                    <x-filament::icon
                                        icon="heroicon-o-check-circle"
                                        style="
                                            width:1.1rem;
                                            height:1.1rem;
                                        "
                                    />

                                    Available

                                </span>

                            </td>

                        </tr>

                    </tfoot>

                @endif

            </table>

        </div>

    </x-filament::section>
</x-filament-widgets::widget>