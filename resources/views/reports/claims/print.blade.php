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
            </div>
            <div style="line-height: 1px">
                <img src="{{ asset('img/logo.jpg') }}" style="height: 85px" alt=""/>
            </div>

        </div>
        <hr style="border: 1px dashed #000; margin-top: 0.2cm"/>

        <div class="body">

            <h4 style="font-weight: bold !important; text-align: center; text-decoration: underline; font-size: 18px">
                مطالبة أعباء صرف صناعي
            </h4>

            <h4>{{ $client->letter_heading}}</h4>
            <h4>العنوان: {{ $client->address}}</h4>
            <h4 style="text-align: center">تحية طيبة وبعد ،،،</h4>
            <p>
                <b>الموضوع /</b> اثناء المرور الدوري للجنة الصرف الصناعي علي الجهة بالعنوان الموضح بعاليه ،تم أخذ عينة
                من السيب النهائي قبل الصرف علي الشبكة العمومية ،وتم عمل محضر بذلك ،وتم أخذ عينة بالتواريخ الموضحة
                بالجدول أدناه .
                وبناء علي ما سبق و طبقاً لقرار السيد رئيس مجلس الوزراء رقم 1012 لسنة 2018 ( اللائحة التجارية الموحدة )
                لمقابل أعباء معالجة صرف المنشآت الصناعية لمعايير القرار الوزاري رقم 44 لسنة 2000 م و طبقا لنتائج تحليل
                العينة طرفكم الموضحة بالجدول التالي:
            </p>
            <table class="table1">
                <thead>
                <tr style="background: #ccc">
                    <th>نوع الملوث</th>
                    <th>تاريخ العينة</th>
                    <th>تركيز الملوث للمصنع مللجم /لتر</th>
                    <th>مقابل الأعباء بالجنيه</th>
                    <th>مهلة توفيق الأوضاع</th>
                </tr>
                </thead>
                <tbody>
                @forelse($results as $result)
                    @forelse($result->resultDetails as $item)
                        <tr>
                            <td>{{ $item->sample?->name }}</td>
                            <td>{{ $result->result_date }}</td>
                            <td>{{$item->value}}</td>
                            <td>{{$item->sampleDetail?->price}}</td>
                            <td>{{$item->sampleDetail?->duration > 0 ? $item->sampleDetail?->duration : '-' }} يوم</td>
                        </tr>
                        @endforeach
                        @endforeach
                </tbody>
            </table>
            <p>برجاء التفضل بسداد مبلغ ({{number_format($data->total_amount, 2)}}) {{tafqeet($data->total_amount)}}
                ،وذلك عن الفترة من {{\Illuminate\Support\Carbon::parse($data->start_date)->format('Y/m/d')}}
                إلى {{\Illuminate\Support\Carbon::parse($data->end_date)->format('Y/m/d')}} واستهلاك شهري
                ({{$data->consumption}}م3) وفقاً للبيان التالي:-</p>
            <table class="table1">
                <thead>
                <tr style="background: #ccc">
                    <th>بيان</th>
                    <th>القيمة</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data->details as $item)
                    <tr>
                        <td>تكلفة إزالة <b>{{ $item->key }}</b></td>
                        <td style="text-align: right; padding-right: 10px">{{number_format($item->value, 2)}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <p>
                لذا نلزمكم بضرورة سداد المستحقات المالية خلال المهلة المحددة وإلا سنضطر إلي مضاعفة قيمة المستحقات وإصدار
                قرار غلق إداري للمنشأة طبقا لقرار مجلس الوزراء رقم 1012 لسنة 2018 .
            </p>
            <table style="width: 100%; border: 0">
                <tr style="text-align: center; border: 0">
                    <td style="border: 0">المختص</td>
                    <td style="border: 0">المشرف على اللجنة</td>
                    <td style="border: 0; text-align: right">نائب رئيس الجهاز</td>
                    <td style="width: 25%; border: 0">
                        <h3 style="">رئيس الجهاز</h3>
                        <h3 style="text-align: right; margin-right: -30px">د. مهندس/</h3>
                        <h3>محمد خلف الله عبد الماجد</h3>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
</body>
</html>
