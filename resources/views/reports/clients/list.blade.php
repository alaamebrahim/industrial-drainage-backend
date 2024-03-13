<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link href="{{ asset('css/a4.css') }}" type="text/css" rel="stylesheet"/>
    <style>
        .header {
            display: flex;
            align-items: first;
        }

        table {
            border-spacing: 0;
            text-align: center;
            width: 100%;
            border: 1px solid #5c5c5c;

        }

        .body table td {
            border: 1px solid #5c5c5c;
        }

        .body table td {
            border: 1px solid #5c5c5c;
            padding: 2px;
        }

        .print-btn-container {
            width: 200px;
            padding: 10px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .table1 td, .table1 tr, .table1 th {
            border: 1px solid #5c5c5c;
        }

        .print-btn {
            background: #1d7c0f;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 150px;
            font-weight: bold;
            cursor: pointer;
            color: white;
        }

        @media print {
            .print-btn-container {
                display: none;
            }

            .print-btn {
                display: none;
                text-align: center;
            }
        }
    </style>
</head>
<body style="--bleeding: 0.5cm;--margin: 1cm;">
<div class="print-btn-container">
    <button onclick="window.print()" class="print-btn">طباعة</button>
</div>
<div class="page">
    <div>
        <div class="header">
            <div style="line-height: 1px">
                <h4>هيئة المجتمعات العمرانية الجديدة</h4>
                <h4>جهاز تنمية مدينة دمياط الجديدة</h4>
            </div>
            <div style="flex-grow: 2; text-align: center">
                <p style="color: #252525;">تاريخ الطباعة: {{now()->format('Y-m-d')}}</p>
                <h4 style="font-weight: bold !important; text-align: center; text-decoration: underline; font-size: 18px">
                    كشف بيانات العملاء
                </h4>
            </div>
            <div style="line-height: 1px">
                <img src="{{ asset('img/logo.jpg') }}" style="height: 85px" alt=""/>
            </div>

        </div>
        <hr style="border: 1px dashed #000; margin-top: 0.2cm"/>

        <div class="body">



            <table class="table1">
                <thead>
                <tr style="background: #ccc">
                    <th>#</th>
                    <th>اسم العميل</th>
                    <th>العنوان</th>
                    <th>عدد العينات</th>
                    <th>عدد المطالبات</th>
                    <th>إجمالي المطالبات</th>
                    <th>إجمالي المسدد</th>
                    <th>صافي المديونية</th>
                </tr>
                </thead>
                <tbody>
                @forelse($data as $client)
                    <tr>
                        <td>{{$loop->index + 1}}</td>
                        <td>{{ $client['name'] }}</td>
                        <td>{{ $client['address'] }}</td>
                        <td>{{ $client['results_count'] }}</td>
                        <td>{{ $client['claims_count'] }}</td>
                        <td>{{ number_format($client['total_amount'], 2)}}</td>
                        <td>{{ number_format($client['amount_paid'], 2) }}</td>
                        <td>{{ number_format($client['net_amount'], 2) }}</td>
                    </tr>
                @empty
                @endforelse
                </tbody>
                <tfoot>
                <tr style="background: #ccc; font-weight: bold">
                    <td style="padding: 10px" colspan="3">الإجمالي</td>
                    <td>{{ $data->sum('results_count') }}</td>
                    <td>{{ $data->sum('claims_count') }}</td>
                    <td>{{ $data->sum('total_amount') }}</td>
                    <td>{{ $data->sum('amount_paid') }}</td>
                    <td>{{ $data->sum('net_amount') }}</td>
                </tr>
                </tfoot>
            </table>

        </div>
    </div>
</div>
</body>
</html>
