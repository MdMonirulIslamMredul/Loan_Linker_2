<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Orders Report</title>
    <style>
        :root {
            --line: #d7dbe1;
            --text: #1d242d;
            --muted: #5f6b7a;
            --header-bg: #f4f6f9;
            --accent: #1f6feb;
            --pending: #8a6d3b;
            --approved: #2d6a4f;
            --rejected: #9f1239;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 24px;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text);
            background: #eef2f7;
        }

        .report-wrap {
            max-width: 1100px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 28px rgba(16, 24, 40, 0.08);
        }

        .report-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 6px 20px;
            border-bottom: 1px solid var(--line);
            background: linear-gradient(110deg, #f8fbff 0%, #f4f7ff 100%);
        }

        .report-title {
            margin: 0;
            font-size: 1.15rem;
            font-weight: 700;
        }

        .report-meta {
            margin-top: 3px;
            color: var(--muted);
            font-size: 0.85rem;
        }

        .print-action {
            border: none;
            background: var(--accent);
            color: #fff;
            border-radius: 8px;
            padding: 9px 16px;
            font-size: 0.9rem;
            cursor: pointer;
            white-space: nowrap;
        }

        .report-body {
            padding: 20px;
        }

        .section-title {
            margin: 0 0 10px;
            font-size: 0.98rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: var(--muted);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 8px;
            margin-bottom: 14px;
        }

        .filter-item {
            border: 1px solid var(--line);
            border-radius: 6px;
            padding: 6px 8px;
            background: #fcfdff;
            min-height: 44px;
        }

        .filter-label {
            font-size: 0.66rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: var(--muted);
            margin-bottom: 2px;
        }

        .filter-value {
            font-size: 0.8rem;
            font-weight: 600;
            word-break: break-word;
            line-height: 1.2;
        }

        .summary-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 16px;
        }

        .summary-item {
            border: 1px solid var(--line);
            border-radius: 999px;
            padding: 6px 12px;
            background: #fff;
            font-size: 0.85rem;
            color: var(--muted);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.88rem;
        }

        th,
        td {
            border: 1px solid var(--line);
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        thead th {
            background: var(--header-bg);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.76rem;
            letter-spacing: 0.02em;
        }

        .amount {
            white-space: nowrap;
            font-weight: 700;
        }

        .status {
            font-weight: 700;
            text-transform: capitalize;
        }

        .status.pending {
            color: var(--pending);
        }

        .status.approved {
            color: var(--approved);
        }

        .status.rejected {
            color: var(--rejected);
        }

        .empty-row {
            text-align: center;
            color: var(--muted);
            padding: 14px;
        }

        @media (max-width: 900px) {
            .filter-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .report-body {
                padding: 12px;
            }

            .filter-grid {
                grid-template-columns: repeat(5, minmax(0, 1fr));
                gap: 6px;
            }

            .filter-item {
                padding: 5px 7px;
                min-height: 40px;
            }

            .filter-label {
                font-size: 0.62rem;
                margin-bottom: 1px;
            }

            .filter-value {
                font-size: 0.76rem;
            }

            .report-wrap {
                border: none;
                border-radius: 0;
                box-shadow: none;
                max-width: 100%;
            }

            .print-action {
                display: none;
            }

            @page {
                size: A4 portrait;
                margin: 12mm;
            }
        }
    </style>
    @if (isset($logoSettings) && $logoSettings->favicon)
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $logoSettings->favicon) }}">
    @endif
</head>

<body>
    <div class="report-wrap">
        <div class="report-header">
            <div>
                @if (isset($logoSettings) && $logoSettings->header_logo)
                <img src="{{ asset('storage/' . $logoSettings->header_logo) }}" alt="Logo" style="max-height: 100px; max-width: 200px; object-fit: contain;">
                @endif
            </div>
            <div style="display: flex; align-items: center; gap: 15px;">
                <div style="text-align: right;">
                    <h1 class="report-title" style="margin-bottom: 5px;">Package Orders Report</h1>
                    <div class="report-meta">Generated: {{ now()->format('d M, Y h:i A') }}</div>
                </div>
                <button type="button" class="print-action" onclick="window.print()">Print</button>
            </div>
        </div>

        <div class="report-body">
            @php
            $appliedFilters = array_filter($filterSummary, function($val) {
            return !empty($val);
            });
            @endphp

            <h2 class="section-title">Applied Filters</h2>
            @if(count($appliedFilters) > 0)
            <div class="filter-grid">
                @if(!empty($filterSummary['search']))
                <div class="filter-item">
                    <div class="filter-label">Officer Search</div>
                    <div class="filter-value">{{ $filterSummary['search'] }}</div>
                </div>
                @endif
                @if(!empty($filterSummary['officer']))
                <div class="filter-item">
                    <div class="filter-label">Officer</div>
                    <div class="filter-value">{{ $filterSummary['officer'] }}</div>
                </div>
                @endif
                @if(!empty($filterSummary['bank']))
                <div class="filter-item">
                    <div class="filter-label">Bank</div>
                    <div class="filter-value">{{ $filterSummary['bank'] }}</div>
                </div>
                @endif
                @if(!empty($filterSummary['package']))
                <div class="filter-item">
                    <div class="filter-label">Package</div>
                    <div class="filter-value">{{ $filterSummary['package'] }}</div>
                </div>
                @endif
                @if(!empty($filterSummary['status']))
                <div class="filter-item">
                    <div class="filter-label">Status</div>
                    <div class="filter-value">{{ $filterSummary['status'] }}</div>
                </div>
                @endif
                @if(!empty($filterSummary['from_date']))
                <div class="filter-item">
                    <div class="filter-label">From Date</div>
                    <div class="filter-value">{{ $filterSummary['from_date'] }}</div>
                </div>
                @endif
                @if(!empty($filterSummary['to_date']))
                <div class="filter-item">
                    <div class="filter-label">To Date</div>
                    <div class="filter-value">{{ $filterSummary['to_date'] }}</div>
                </div>
                @endif
            </div>
            @else
            <div style="font-size: 0.85rem; color: #666; margin-bottom: 20px;">No filter applied</div>
            @endif

            <div class="summary-row">
                <div class="summary-item">Total Orders: {{ $orders->count() }}</div>
                <div class="summary-item">Total Leads: {{ number_format($orders->sum('number_of_leads')) }}</div>
                <div class="summary-item">Total Amount: BDT {{ number_format($orders->sum('price'), 2) }}</div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Invoice No</th>
                        <th>Officer Name</th>
                        <th>Officer ID</th>
                        <th>Bank</th>
                        <th>Package</th>
                        <th>Leads</th>
                        <th>Price</th>
                        <th>Order Date</th>
                        <!-- <th>Approval Date</th> -->
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                    <tr>
                        <td>INV-LEAD-{{ sprintf('%03d', $order->id) }}</td>
                        <td>{{ $order->user->name ?? '-' }}</td>
                        <td> ID#{{ $order->user->id ?? '-' }}</td>
                        <td>{{ optional($order->user->bank)->name ?? '-' }}</td>
                        <td>{{ $order->leadPackage->name ?? '-' }}</td>
                        <td>{{ $order->number_of_leads }}</td>
                        <td class="amount">৳ {{ number_format($order->price, 2) }}</td>
                        <td>{{ $order->created_at ? $order->created_at->format('d M, Y') : '-' }}</td>
                        <!-- <td>{{ $order->approved_at ? \Carbon\Carbon::parse($order->approved_at)->format('d M, Y') : 'Not approved' }}
                        </td> -->
                        <td>
                            <span class="status {{ strtolower($order->status) }}">{{ $order->status }}</span>
                            @if(strtolower($order->status) === 'approved' && $order->approved_at)
                            <div style="font-size: 0.65rem; color: #666; margin-top: 2px;">{{ \Carbon\Carbon::parse($order->approved_at)->format('d M, Y h:i A') }}</div>
                            @elseif(strtolower($order->status) === 'rejected' && $order->rejected_at)
                            <div style="font-size: 0.65rem; color: #666; margin-top: 2px;">{{ \Carbon\Carbon::parse($order->rejected_at)->format('d M, Y h:i A') }}</div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="empty-row">No records found for the selected filters.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>