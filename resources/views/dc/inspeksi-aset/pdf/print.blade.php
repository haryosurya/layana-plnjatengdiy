<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>@lang('app.invoice')</title>
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

        header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #AAAAAA;
        }

        #logo {
            float: left;
            margin-top: 11px;
        }

        #logo img {
            height: 55px;
            margin-bottom: 15px;
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
        }

        table th,
        table td {
            padding: 5px 10px 7px 10px;
            /* background: #EEEEEE; */
            /* text-align: left; */
            border-bottom: 1px solid #FFFFFF;
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
            border: none;
            align :left;
        }

        table tfoot td {
            padding: 10px 10px 20px 10px;
            background: #FFFFFF;
            border-bottom: none;
            font-size: 1.2em;
            white-space: nowrap;
            border-bottom: 1px solid #AAAAAA;
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
<body>
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
     
    <table border="1" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th class="no" align="center" colspan="5">PEMERIKSAAN PERALATAN SCADATEL</th> 
            </tr>
            <tr>
                <th class="q">NO</th>
                <th class="q" >ITEM PEMERIKSAAN</th>
                <th class="q" colspan="2">HASIL PEMERIKSAAN</th> 
                <th class="q" >KETERANGAN</th> 
            </tr>
            <tr>
                <th></th> 
                <th></th> 
                <th></th> 
                <th></th> 
            </tr>
        </thead>
        <tbody align="left">
            <tr>
                <td class="q"  >1</td>
                <td class="q" align="left" colspan="4">KEBERSIHAN KUBIKEL</td>
            </tr> 
            <tr>
                <th class=""></th> 
                <th class="">1. BODY KUBIKEL</th> 
                <th class="">
                    @if ($pd->body_cubicle == 'Bersih')
                    &#9745;
                    {{$pd->body_cubicle}} 
                    @else
                    &#9744; 
                    @endif
                </th> 
                <th class="">&#9744;</th>
                <th class=""> </th>
            </tr>
            <tr>
                <th class=""></th> 
                <th class="">2. LV COMPARTMENT</th>  
                <th class="">&#9744;</th> 
                <th class="">&#9745;</th>
            </tr>
            <tr>
                <th class=""></th> 
                <th class="">3. EXHAUST FAN</th>  
                <th class="">#</th>  
                <th class="">#</th>  
            </tr> 
        </tbody> 
    </table>
    <p>&nbsp;</p>
    <hr>
    <p id="notes">
      note
    </p>

</main>
</body>
</html>
