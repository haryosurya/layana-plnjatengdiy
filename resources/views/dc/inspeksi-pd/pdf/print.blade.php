<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>@lang('app.menu.inspeksi-pd')</title> 
    <link type="text/css" rel="stylesheet" media="all" href="{{ asset('css/prnt.css') }}">
    <style>

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #0087C3;
            text-decoration: none;
        }

        body {
            position: relative;
            width: 100%;
            height: auto;
            margin: 0 auto;
            color: #555555;
            background: #FFFFFF;
            font-size: 14px;
            font-family: Verdana, Arial, Helvetica, sans-serif;
        }

        h2 {
            font-weight:normal;
        }
 

        #logo {
            float: left;
            margin-top: 11px;
        }

        #logo img {
            height: 50px;
            margin-bottom: 10px;
        }

        #company {

        }

        #details {
            margin-bottom: 50px;
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

        #invoice {

        }

        #invoice h1 {
            color: #0087C3;
            font-size: 2.4em;
            line-height: 1em;
            font-weight: normal;
            margin: 0 0 10px 0;
        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;
        }

        table {
            width: 100%;
            border-spacing: 0;
            margin-bottom: 20px;
            white-space:nowrap;
        }

        table th,
        table td {
            padding: 5px 10px 7px 10px;
            /* background: #EEEEEE; */
            /* text-align: left; */
            /* border-bottom: 1px solid #FFFFFF; */
        }

        table th {
            white-space: nowrap;
            font-weight: normal;
        }

        table td {
            /* text-align: center; */
        }

        table td.desc h3, table td.q h3 {
            color: #57B223;
            font-size: 1.2em;
            font-weight: normal;
            margin: 0 0 0 0;
        }

        table .no {
            color: #FFFFFF;
            font-size: 1.6em;
            background: #57B223;
            width: 10%;
        }

        table .desc {
            text-align: left;
        }

        table .unit {
            background: #DDDDDD;
        }


        table .total {
            background: #57B223;
            color: #FFFFFF;
        }

        table td.unit,
        table td.qty,
        table td.total
        {
            font-size: 1.2em;
            text-align: center;
        }

        table td.unit{
            width: 35%;
        }

        table td.desc{
            width: 45%;
        }

        table td.qty{
            width: 5%;
        }

        .status {
            margin-top: 15px;
            padding: 1px 8px 5px;
            font-size: 1.3em;
            width: 80px;
            color: #fff;
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
            color: #1BA39C;
        }
        table tr.discount .desc {
            text-align: right;
            color: #E43A45;
        }
        table tr.subtotal .desc {
            text-align: right;
            color: #1d0707;
        }
        table tbody tr:last-child td {
            /* border: none; */
            align :left;
        }

        table tfoot td {
            padding: 10px 10px 20px 10px;
            background: #FFFFFF;
            border-bottom: none;
            font-size: 1.2em;
            white-space: nowrap;
            /* border-bottom: 1px solid #AAAAAA; */
        }

        table tfoot tr:first-child td {
            border-top: none;
        }

        table tfoot tr td:first-child {
            border: none;
        }

        #thanks {
            font-size: 2em;
            margin-bottom: 50px;
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
            border-top: 1px solid #AAAAAA;
            padding: 8px 0;
            text-align: center;
        }

        .q {
            background-color: rgb(189, 189, 189);
            align:left;
        }

        table td div#invoiced_to {
            text-align: left;
        }

        #notes{
            color: #767676;
            font-size: 11px;
        }

        .item-summary{
            font-size: 12px
        }

        .mb-3{
            margin-bottom: 1rem;
        }

        .logo {
            text-align: right;
        }
        .logo img {
            max-width: 150px !important;
        }
    </style>
</head>
<body class="content-wrapper"> 
     
    <main> 
        <table cellpadding="0" cellspacing="0"  > 
            <tr>
                <td  style=" vertical-align:top ; width:80%">
                    <div id="logo">
                        <img src="{{ $global->logo_url }}" alt="home" class="dark-logo" />
                        <div>
                            <small>@lang("modules.invoices.generatedBy"):</small>
                            <div>{{ ucwords($global->company_name) }}</div>  
                        </div>
                    </div>
                </td> 
                <td  style="width:20%" align="right">
                    <table>
                        <tr>
                            <td>Operator</td>
                            <td> {{ ucwords($pd->user->name??"") }}</td>
                        </tr>
                        <tr>
                            <td>Id Inspeksi</td>
                            <td> {{ ucfirst($pd->id_inspeksi_pd) }}</td>
                        </tr>
                        <tr>
                            <td>Kubikel</td>
                            <td>{{ ucwords($pd->Cubicle->CUBICLE_NAME) }}</td>
                        </tr>
                        <tr>
                            <td>Gardu Induk</td>
                            <td>{{ ucwords($pd->Cubicle->dcIncomingFeeder->dcGarduInduk->GARDU_INDUK_NAMA) }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Entry</td>
                            <td>{!! nl2br($pd->tgl_entry) !!}</td>
                        </tr>
                    </table>  
                </td>
            </tr>
        </table> 
        <table align="left" cellpadding="0" cellspacing="0"  > 
            <tr>
                <td>
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
                </td>
                <td>
                    <div class="form-group my-3">
                        <label class="f-14 text-dark-grey mb-8 w-100"
                            for="usr">@lang('modules.inspeksi.cpd')</label> 
                        <div class="d-flex">

                            <span>
                                {{ $pd->citicality ?? '' }}
                            </span> 
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group my-3">
                        <label class="f-14 text-dark-grey mb-8 w-100"
                            for="usr">@lang('modules.inspeksi.cpd')</label> 
                        <div class="d-flex">

                            <span>
                                {{ $pd->keterangan ?? '' }}
                            </span> 
                        </div>
                    </div>
                </td>
                <td>
                    <tr>
                        <td colspan="2">
                            <div class="form-group my-3">  
                                <label class="f-14 text-dark-grey mb-8 w-100"
                                    for="usr">@lang('modules.inspeksi.foto_p')</label> 
                                <span>
                                    @php
                                    $file = json_decode($pd->foto_pelaksanaan); 
                                    @endphp   
                                    <br>
                                    {{-- <a href="javascript:;" class="img-lightbox" data-image-url="{{ $file->image_url }}"> --}}
                                        <img src="{{ $file->image_url }}" width="200" height="200" class="p-20 img-thumbnail">
                                    {{-- </a>   --}}
                                </span> 
                            </div>
                        </td>
                        <td colspan="2">
                            <div class="form-group my-3">  
                                <label class="f-14 text-dark-grey mb-8 w-100"
                                    for="usr">@lang('modules.inspeksi.foto_pe')</label> 
                                <span>
                                    @php
                                    $filep = json_decode($pd->foto_pengukuran); 
                                    @endphp   
                                    <br>
                                    {{-- <a href="javascript:;" class="img-lightbox" data-image-url="{{ $filep->image_url }}"> --}}
                                        <img src="{{ $filep->image_url }}" width="200" height="200" class="p-20 img-thumbnail">
                                    {{-- </a> --}}
                                </span> 
                            </div>
                        </td>
                    </tr>
                </td>
            </tr>
        </table> 

    </main>
</body>

</html>
