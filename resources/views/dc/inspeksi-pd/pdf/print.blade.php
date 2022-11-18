a<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>@lang('app.menu.inspeksi-pd')</title> 
    <link type="text/css" rel="stylesheet" media="all" href="{{ asset('css/prnt.css') }}">
    <style> 

        a {
            text-decoration: none;
        }

        body {
            position: relative;
            width: 100%;
            height: auto;
            margin: 0 auto;
            color: #555555;
            background: #FFFFFF;
            font-size: 13px;
            font-family: Verdana, Arial, Helvetica, sans-serif;
        }

        h2 {
            font-weight: normal;
        }

        header {
            padding: 10px 0;
        }

        #logo img {
            height: 33px;
            margin-bottom: 15px;
        }

        #details {
            margin-bottom: 25px;
        }

        #client {
            padding-left: 6px;
            float: left;
        }

        #client .to {
            color: #777777;
        }

        h2.name {
            font-size: 1.2em;
            font-weight: normal;
            margin: 0;
        }

        #invoice h1 {
            color: #0087C3;
            line-height: 2em;
            font-weight: normal;
            margin: 0 0 10px 0;
            font-size: 20px;
        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;
        }

        table {
            width: 100%;
            border-spacing: 0;
            /* margin-bottom: 20px; */
        }

        table th,
        table td {
            padding: 5px 8px;
            text-align: center;
        }

        table th {
            background: #EEEEEE;
        }

        table th {
            white-space: nowrap;
            font-weight: normal;
        }

        table td {
            text-align: right;
        }

        table td.desc h3,
        table td.qty h3 {
            font-size: 0.9em;
            font-weight: normal;
            margin: 0 0 0 0;
        }

        table .no {
            font-size: 1.2em;
            width: 10%;
            text-align: center;
            border-left: 1px solid #e7e9eb;
        }

        table .desc, table .item-summary  {
            text-align: left;
        }

        table .unit {
            /* background: #DDDDDD; */
            border: 1px solid #e7e9eb;
        }


        table .total {
            background: #57B223;
            color: #FFFFFF;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
            text-align: center;
        }

        table td.unit {
            width: 35%;
        }

        table td.desc {
            width: 45%;
        }

        table td.qty {
            width: 5%;
        }

        .status {
            margin-top: 15px;
            padding: 1px 8px 5px;
            font-size: 1.3em;
            width: 80px;
            float: right;
            text-align: center;
            display: inline-block;
        }

        .status.unpaid {
            background-color: #E7505A;
        }

        .status.paid {
            background-color: #26C281;
        }

        .status.cancelled {
            background-color: #95A5A6;
        }

        .status.error {
            background-color: #F4D03F;
        }

        table tr.tax .desc {
            text-align: right;
        }

        table tr.discount .desc {
            text-align: right;
            color: #E43A45;
        }

        table tr.subtotal .desc {
            text-align: right;
        }


        table tfoot td {
            padding: 10px;
            font-size: 1.2em;
            white-space: nowrap;
            border-bottom: 1px solid #e7e9eb;
            font-weight: 700;
        }

        table tfoot tr:first-child td {
            border-top: none;
        }

        table tfoot tr td:first-child {
            /* border: none; */
        }


        #notices {
            padding-left: 6px;
            border-left: 6px solid #0087C3;
        }

        #notices .notice {
            font-size: 1.2em;
        }

        footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #e7e9eb;
            padding: 8px 0;
            text-align: center;
        }

        table.billing td {
            background-color: #fff;
        }

        table td#invoiced_to {
            text-align: left;
            padding-left: 0;
        }

        #notes {
            color: #767676;
            font-size: 11px;
        }

        .item-summary {
            font-size: 11px;
            padding-left: 0;
        }


        .page_break {
            page-break-before: always;
        }


        table td.text-center {
            text-align: center;
        }

        .word-break {
            word-wrap:break-word;
        }

        #invoice-table td {
            border: 1px solid #e7e9eb;
        }

        .border-left-0 {
            border-left: 0 !important;
        }

        .border-right-0 {
            border-right: 0 !important;
        }

        .border-top-0 {
            border-top: 0 !important;
        }

        .border-bottom-0 {
            border-bottom: 0 !important;
        }


    </style>
</head>
<body class="content-wrapper"> 
    <header class="clearfix">
        <table cellpadding="0" cellspacing="0"  > 
            <tr>
                <td id="invoiced_to">
                    <div>  
                            <div>{{ ucfirst($pd->id_inspeksi_pd) }}</div>
                            <div>{{ ucwords($pd->Cubicle->CUBICLE_NAME) }}</div>
                            <div>{{ ucwords($pd->Cubicle->dcIncomingFeeder->NAMA_ALIAS_INCOMING) }}</div>
                            <div>{{ ucwords($pd->Cubicle->dcIncomingFeeder->dcGarduInduk->GARDU_INDUK_NAMA) }}</div>
                            <div class="mb-3">
                                <div>@lang('app.date') :</div>
                                <div>{!! nl2br($pd->tgl_entry) !!}</div>
                            </div>  
                          
                    </div>
                </td>
                <td>
                    <div id="company">
                        <div id="logo">
                            <img src="{{ $global->logo_url }}" alt="home" class="dark-logo" />
                        </div>
                            <small>@lang("modules.invoices.generatedBy"):</small>
                        <div>{{ ucwords($global->company_name) }}</div>
                         
                    </div>
                </td>
            </tr>
        </table>
    </header>
    <main> 
        <div id="details">
            <div class="row">
                <div class="col-sm-12">
                    <x-form id="save-data-form" method="PUT">
                        <div class="add-client bg-white rounded"> 
                            <div class="row p-20">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group my-3">
                                        <label class="f-14 text-dark-grey mb-8 w-100"
                                            for="usr">@lang('modules.inspeksi.lpd')</label>
                                        <div class="d-flex">
                                            @php
                                                if ($pd->level_pd  == 'good' && $pd->level_pd  != '') 
                                                {
                                                    $pds = '  <i class="fa fa-circle mr-1 text-light-green f-10"></i> <span class="badge badge-success">' . __('app.good')  .'</span>';
                                                }
                                                elseif ($pd->level_pd  == 'moderate' && $pd->level_pd  != '') 
                                                {
                                                    $pds =  '<i class="fa fa-circle mr-1 text-yellow f-10"></i> <span class="badge badge-warning">' . __('app.moderate')  .'</span>'; 
                                                }
                                                elseif ($pd->level_pd  == 'bad' && $pd->level_pd  != '') 
                                                {
                                                    $pds =  ' <i class="fa fa-circle mr-1 text-red f-10"></i> <span class="badge badge-danger">' . __('app.bad')  .'</span>';
                                                }
                                                else{
                                                    $pds =  '';
                                                }  
                                                echo $pds ;
                                            @endphp
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group my-3">
                                        <label class="f-14 text-dark-grey mb-8 w-100"
                                            for="usr">@lang('modules.inspeksi.cpd')</label> 
                                            <span>
                                                {{ $pd->citicality ?? '' }}
                                            </span> 
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group my-3"> 
                                        <label class="f-14 text-dark-grey mb-8 w-100"
                                        for="usr">@lang('modules.inspeksi.keterangan')</label>
                                        <span>
                                            {{$pd->keterangan}}
                                        </span> 
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6"> 
                                    <div class="form-group my-3">  
                                        <label class="f-14 text-dark-grey mb-8 w-100"
                                            for="usr">@lang('modules.inspeksi.cpd')</label> 
                                        <span>
                                            {{ $pd->citicality ?? '' }}
                                        </span> 
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6"> 
                                    <div class="form-group my-3">  
                                        <label class="f-14 text-dark-grey mb-8 w-100"
                                            for="usr">@lang('modules.inspeksi.foto_p')</label> 
                                        <span>
                                            @php
                                            $file = json_decode($pd->foto_pelaksanaan); 
                                            @endphp   
                                            <br>
                                            {{-- <a href="javascript:;" class="img-lightbox" data-image-url="{{ $file->image_url }}"> --}}
                                                <img src="{{ $file->image_url }}" width="100" height="100" class="p-20 img-thumbnail">
                                            {{-- </a>   --}}
                                        </span> 
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6"> 
                                    <div class="form-group my-3">  
                                        <label class="f-14 text-dark-grey mb-8 w-100"
                                            for="usr">@lang('modules.inspeksi.foto_pe')</label> 
                                        <span>
                                            @php
                                            $filep = json_decode($pd->foto_pengukuran); 
                                            @endphp   
                                            <br>
                                            {{-- <a href="javascript:;" class="img-lightbox" data-image-url="{{ $filep->image_url }}"> --}}
                                                <img src="{{ $filep->image_url }}" width="100" height="100" class="p-20 img-thumbnail">
                                            {{-- </a> --}}
                                        </span> 
                                    </div>
                                </div> 
                            </div>  
                        </div>
                    </x-form>

                </div>
            </div>
        </div> 
         

    </main>
</body>

</html>
