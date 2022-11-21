<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>export inspeksi aset</title>
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
<body> 
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
                        <td> {{ ucwords($aset->user->name??"") }}</td>
                    </tr>
                    <tr>
                        <td>Id Inspeksi</td>
                        <td> {{ ucfirst($aset->id_inspeksi_pd) }}</td>
                    </tr>
                    <tr>
                        <td>Kubikel</td>
                        <td>{{ ucwords($aset->Cubicle->CUBICLE_NAME) }}</td>
                    </tr>
                    <tr>
                        <td>Gardu Induk</td>
                        <td>{{ ucwords($aset->Cubicle->dcIncomingFeeder->dcGarduInduk->GARDU_INDUK_NAMA) }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Entry</td>
                        <td>{!! nl2br($aset->tgl_entry) !!}</td>
                    </tr>
                </table>  
            </td>
        </tr>
    </table> 
    <table border="2" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th class="no" align="center" colspan="5">PEMERIKSAAN PERALATAN SCADATEL</th> 
            </tr>
            <tr >
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
                <th></th> 
            </tr>
        </thead>
        <tbody  border="2"  align="left">
            <tr>
                <td class="q"  >1</td>
                <td class="q" align="left" colspan="4">KEBERSIHAN KUBIKEL</td>
            </tr> 
            <tr>
                <td class=""></td> 
                <td class="">1. BODY KUBIKEL</td> 
                <td class="">
                    <x-forms.checkbox fieldId="body_cubicle_bersih" :fieldLabel="__('app.bersih')" 
                        fieldName="body_cubicle"
                        fieldValue="Bersih" :checked="($aset->body_cubicle == 'Bersih') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="body_cubicle_kotor" :fieldLabel="__('app.kotor')" 
                        fieldValue="Kotor"
                        fieldName="body_cubicle"
                        :checked="($aset->body_cubicle == 'Kotor') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">2. LV COMPARTMENT</td>  
                    <td>
                    <x-forms.checkbox fieldId="lv_bersih" :fieldLabel="__('app.bersih')" 
                        fieldName="lv"
                        fieldValue="Bersih" :checked="($aset->lv == 'Bersih') ? 'checked' : ''">
                    </x-forms.checkbox>
                    </td>
                    <td>
                    <x-forms.checkbox fieldId="lv_kotor" :fieldLabel="__('app.kotor')" 
                        fieldName="lv"
                        fieldValue="Kotor" 
                        :checked="($aset->lv == 'Kotor') ? 'checked' : ''">
                    </x-forms.checkbox>
                    </td>
                <td class=""> </td>

            </tr>
            
            <tr>
                <td class=""></td> 
                <td class="">3. CB COMPARTMENT</td>  
                <td>
                    <x-forms.checkbox fieldId="cb_bersih" :fieldLabel="__('app.bersih')" 
                        fieldName="cb"
                        fieldValue="Bersih" 
                        :checked="($aset->cb == 'Bersih') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td>
                    <x-forms.checkbox fieldId="cb_kotor" :fieldLabel="__('app.kotor')" 
                        fieldName="cb"
                        fieldValue="Kotor"
                        :checked="($aset->cb == 'Kotor') ? 'checked' : ''" >
                    </x-forms.checkbox>
                </td>
                <td class=""></td>   
            </tr>  
            <tr>
                <td class=""></td> 
                <td class="">4. BUSBAR COMPARTMENT</td>  
                    <td>
                    <x-forms.checkbox fieldId="busbar_bersih" :fieldLabel="__('app.bersih')" 
                                    fieldName="busbar"
                                    fieldValue="Bersih"  
                                    :checked="($aset->busbar == 'Bersih') ? 'checked' : ''">
                    </x-forms.checkbox>
                    </td>
                    <td>
                    <x-forms.checkbox fieldId="busbar_kotor" :fieldLabel="__('app.kotor')" 
                        fieldName="busbar"
                        fieldValue="Kotor" 
                        :checked="($aset->busbar == 'Kotor') ? 'checked' : ''">
                    </x-forms.checkbox>
                    </td>
                <td class=""></td>   
            </tr> 
            <tr>
                <td class=""></td> 
                <td class="">5. KABEL POWER COMPARTMENT</td>  
                    <td>
                    <x-forms.checkbox fieldId="power_cable_bersih" :fieldLabel="__('app.bersih')" 
                        fieldName="power_cable"
                        fieldValue="Bersih" 
                        :checked="($aset->power_cable == 'Bersih') ? 'checked' : ''">
                    </x-forms.checkbox>
                    </td>
                    <td>
                    <x-forms.checkbox fieldId="power_cable_kotor" :fieldLabel="__('app.kotor')" 
                        fieldName="power_cable"
                        fieldValue="Kotor"
                        :checked="($aset->power_cable == 'Kotor') ? 'checked' : ''" >
                    </x-forms.checkbox>
                    </td>
                <td class=""></td>   
            </tr> 
            <tr>
                <td class=""></td> 
                <td class="">6. PMT</td>  
                    <td>
                    <x-forms.checkbox fieldId="pmt_cb_bersih" :fieldLabel="__('app.bersih')" 
                        fieldName="pmt_cb"
                        fieldValue="Bersih" 
                        :checked="($aset->pmt_cb == 'Bersih') ? 'checked' : ''">
                    </x-forms.checkbox>
                    </td>
                    <td>
                    <x-forms.checkbox fieldId="pmt_cb_kotor" :fieldLabel="__('app.kotor')" 
                        fieldName="pmt_cb"
                        fieldValue="Kotor" 
                        :checked="($aset->pmt_cb == 'Kotor') ? 'checked' : ''">
                    </x-forms.checkbox>
                    </td>
                <td class=""></td>   
            </tr> 
            <tr>
                <td class="q"  >2</td>
                <td class="q" align="left" colspan="4">ASSESORIES KUBIKEL 20 KV</td>
            </tr> 
            <tr>
                <td class=""></td> 
                <td class="">1. ANNOUNCIATOR</td> 
                <td class="">
                    <x-forms.checkbox fieldId="announ-baik" :fieldLabel="__('app.baik')" 
                    fieldName="announ"
                    fieldValue="Baik" :checked="($aset->announ == 'Baik') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="announ-tbaik" :fieldLabel="__('app.tbaik')" 
                    fieldName="announ"
                    fieldValue="Tidak Baik"
                    :checked="($aset->announ == 'Tidak Baik') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">2. LAMPU INDIKASI</td> 
                <td class="">
                    <x-forms.checkbox fieldId="ind_lamp-baik" :fieldLabel="__('app.baik')" 
                    fieldName="ind_lamp"
                    fieldValue="Baik" :checked="($aset->ind_lamp == 'Baik') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="ind_lamp-tbaik" :fieldLabel="__('app.tbaik')" 
                    fieldName="ind_lamp"
                    fieldValue="Tidak Baik"
                    :checked="($aset->ind_lamp == 'Tidak Baik') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">3. INDIKASI TEGANGAN (CVD)</td> 
                <td class="">
                    <x-forms.checkbox fieldId="ind_volt-baik" :fieldLabel="__('app.baik')" 
                    fieldName="ind_volt"
                    fieldValue="Baik" :checked="($aset->ind_volt == 'Baik') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="ind_volt-tbaik" :fieldLabel="__('app.tbaik')" 
                    fieldName="ind_volt"
                    fieldValue="Tidak Baik"
                    :checked="($aset->ind_volt == 'Tidak Baik') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">4. SUPPLY AC 220V</td> 
                <td class="">
                    <x-forms.checkbox fieldId="ac220-baik" :fieldLabel="__('app.baik')" 
                    fieldName="ac220"
                    fieldValue="Baik" :checked="($aset->ac220 == 'Baik') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="ac220-tbaik" :fieldLabel="__('app.tbaik')" 
                    fieldName="ac220"
                    fieldValue="Tidak Baik"
                    :checked="($aset->ac220 == 'Tidak Baik') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">5. SUPPLY DC 110 V</td> 
                <td class="">
                    <x-forms.checkbox fieldId="dc110-baik" :fieldLabel="__('app.baik')" 
                    fieldName="dc110"
                    fieldValue="Baik" :checked="($aset->dc110 == 'Baik') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="dc110-tbaik" :fieldLabel="__('app.tbaik')" 
                    fieldName="dc110"
                    fieldValue="Tidak Baik"
                    :checked="($aset->dc110 == 'Tidak Baik') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class="q"  >3</td>
                <td class="q" align="left" colspan="4">TANDA - TANDA KELAIAN KUBIKEL 20 KV</td>
            </tr> 
            <tr>
                <td class=""></td> 
                <td class="">1. SUARA DESIS</td> 
                <td class="">
                    <x-forms.checkbox fieldId="desis-ada" :fieldLabel="__('app.ada')" 
                    fieldName="desis"
                    fieldValue="Ada" :checked="($aset->desis == 'Ada') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="desis-tada" :fieldLabel="__('app.tada')" 
                    fieldName="desis"
                    fieldValue="Tidak Ada"
                    :checked="($aset->desis == 'Tidak Ada') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">2. SUARA DENGUNG</td> 
                <td class="">
                    <x-forms.checkbox fieldId="dengung-ada" :fieldLabel="__('app.ada')" 
                    fieldName="dengung"
                    fieldValue="Ada" :checked="($aset->dengung == 'Ada') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="dengung-tada" :fieldLabel="__('app.tada')" 
                    fieldName="dengung"
                    fieldValue="Tidak Ada"
                    :checked="($aset->dengung == 'Tidak Ada') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">3. SUARA NGETER</td> 
                <td class="">
                    <x-forms.checkbox fieldId="ngeter-ada" :fieldLabel="__('app.ada')" 
                    fieldName="ngeter"
                    fieldValue="Ada" :checked="($aset->ngeter == 'Ada') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="ngeter-tada" :fieldLabel="__('app.tada')" 
                    fieldName="ngeter"
                    fieldValue="Tidak Ada"
                    :checked="($aset->ngeter == 'Tidak Ada') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">4. FLASH OVER</td> 
                <td class="">
                    <x-forms.checkbox fieldId="flash-ada" :fieldLabel="__('app.ada')" 
                    fieldName="flash"
                    fieldValue="Ada" :checked="($aset->flash == 'Ada') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="flash-tada" :fieldLabel="__('app.tada')" 
                    fieldName="flash"
                    fieldValue="Tidak Ada"
                    :checked="($aset->flash == 'Tidak Ada') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">5. BAU SANGIT (TERBAKAR)</td> 
                <td class="">
                    <x-forms.checkbox fieldId="sangit-ada" :fieldLabel="__('app.ada')" 
                    fieldName="sangit"
                    fieldValue="Ada" :checked="($aset->sangit == 'Ada') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="sangit-tada" :fieldLabel="__('app.tada')" 
                    fieldName="sangit"
                    fieldValue="Tidak Ada"
                    :checked="($aset->sangit == 'Tidak Ada') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">6. BAU AMIS</td> 
                <td class="">
                    <x-forms.checkbox fieldId="amis-ada" :fieldLabel="__('app.ada')" 
                    fieldName="amis"
                    fieldValue="Ada" :checked="($aset->amis == 'Ada') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="amis-tada" :fieldLabel="__('app.tada')" 
                    fieldName="amis"
                    fieldValue="Tidak Ada"
                    :checked="($aset->amis == 'Tidak Ada') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr> 
            <tr>
                <td class="q"  >4</td>
                <td class="q" align="left" colspan="4">STATUS KUBIKEL 20 KV</td>
            </tr> 
            <tr>
                <td class=""></td> 
                <td class="">1. FEEDER</td> 
                <td class="">
                    <x-forms.checkbox fieldId="feeder-ada" :fieldLabel="__('app.operasi')" 
                    fieldName="feeder"
                    fieldValue="Operasi" :checked="($aset->feeder == 'Operasi') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="feeder-tada" :fieldLabel="__('app.cadangan')" 
                    fieldName="feeder"
                    fieldValue="Cadangan"
                    :checked="($aset->feeder == 'Cadangan') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">2. KUBIKEL</td> 
                <td class="">
                    <x-forms.checkbox fieldId="kubikel-ada" :fieldLabel="__('app.berbeban')" 
                    fieldName="kubikel"
                    fieldValue="Berbeban" :checked="($aset->kubikel == 'Berbeban') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="kubikel-tada" :fieldLabel="__('app.bertegangan')" 
                    fieldName="kubikel"
                    fieldValue="Bertegangan"
                    :checked="($aset->kubikel == 'Bertegangan') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">3. PMT</td> 
                <td class="">
                    <x-forms.checkbox fieldId="pmt-ada" :fieldLabel="__('app.testpos')" 
                    fieldName="pmt"
                    fieldValue="Test Posisi" :checked="($aset->pmt == 'Test Posisi') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="pmt-tada" :fieldLabel="__('app.servpos')" 
                    fieldName="pmt"
                    fieldValue="Service Posisi"
                    :checked="($aset->pmt == 'Service Posisi') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">4. PERTANAHAN (GROUNDING)</td> 
                <td class="">
                    <x-forms.checkbox fieldId="grounding-on" :fieldLabel="__('app.on')" 
                    fieldName="grounding"
                    fieldValue="On" 
                    :checked="($aset->grounding == 'On') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="grounding-off" :fieldLabel="__('app.off')" 
                    fieldName="grounding"
                    fieldValue="Off"
                    :checked="($aset->grounding == 'Off') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">5. BAU SANGIT (TERBAKAR)</td> 
                <td class="">
                    <x-forms.checkbox fieldId="sangit2-ada" :fieldLabel="__('app.ada')" 
                    fieldName="sangit2"
                    fieldValue="On" 
                    :checked="($aset->sangit2 == 'Ada') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="sangit2-tada" :fieldLabel="__('app.tada')" 
                    fieldName="sangit2"
                    fieldValue="Tidak Ada"
                    :checked="($aset->sangit2 == 'Tidak Ada') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">6. SWITCH LOCAL - REMOTE</td> 
                <td class="">
                    <x-forms.checkbox fieldId="slr-ada" :fieldLabel="__('app.local')" 
                    fieldName="slr"
                    fieldValue="Local" 
                    :checked="($aset->slr == 'Local') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="slr-remote" :fieldLabel="__('app.remote')" 
                    fieldName="slr"
                    fieldValue="Remote"
                    :checked="($aset->slr == 'Remote') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">7. SWITCH AUTO RECLOSE</td> 
                <td class="">
                    <x-forms.checkbox fieldId="sar-on" :fieldLabel="__('app.on')" 
                    fieldName="sar"
                    fieldValue="On" 
                    :checked="($aset->sar == 'On') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="sar-off" :fieldLabel="__('app.off')" 
                    fieldName="sar"
                    fieldValue="Off"
                    :checked="($aset->sar == 'Off') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class="q"  >5</td>
                <td class="q" align="left" colspan="4">PERALATAN PROTEKSI DAN METERING</td>
            </tr> 
            <tr>
                <td class=""></td> 
                <td class="">1. BODY PERALATAN</td> 
                <td class="">
                    <x-forms.checkbox fieldId="body_alat-bersih" :fieldLabel="__('app.bersih')" 
                    fieldName="body_alat"
                    fieldValue="Bersih" :checked="($aset->body_alat == 'Bersih') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="body_alat-kotor" :fieldLabel="__('app.kotor')" 
                    fieldName="body_alat"
                    fieldValue="Kotor"
                    :checked="($aset->body_alat == 'Kotor') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">2. KABEL WIRING</td> 
                <td class="">
                    <x-forms.checkbox fieldId="wiring-bersih" :fieldLabel="__('app.bersih')" 
                    fieldName="wiring"
                    fieldValue="Bersih" :checked="($aset->wiring == 'Bersih') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="wiring-kotor" :fieldLabel="__('app.kotor')" 
                    fieldName="wiring"
                    fieldValue="Kotor"
                    :checked="($aset->wiring == 'Kotor') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">3. KONDISI WIRING PROTEKSI</td> 
                <td class="">
                    <x-forms.checkbox fieldId="w_prot-kencang" :fieldLabel="__('app.kencang')" 
                    fieldName="w_prot"
                    fieldValue="Kencang" :checked="($aset->w_prot == 'Kencang') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="w_prot-kendor" :fieldLabel="__('app.kendor')" 
                    fieldName="w_prot"
                    fieldValue="Kendor"
                    :checked="($aset->w_prot == 'Kendor') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">4. KONDISI WIRING METERING</td> 
                <td class="">
                    <x-forms.checkbox fieldId="w_meter-kencang" :fieldLabel="__('app.kencang')" 
                    fieldName="w_meter"
                    fieldValue="Kencang" :checked="($aset->w_meter == 'Kencang') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="w_meter-kendor" :fieldLabel="__('app.kendor')" 
                    fieldName="w_meter"
                    fieldValue="Kendor"
                    :checked="($aset->w_meter == 'Kendor') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">5. KONDISI WIRING ASSESORIES</td> 
                <td class="">
                    <x-forms.checkbox fieldId="w_acc-kencang" :fieldLabel="__('app.kencang')" 
                    fieldName="w_acc"
                    fieldValue="Kencang" :checked="($aset->w_acc == 'Kencang') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="w_acc-kendor" :fieldLabel="__('app.kendor')" 
                    fieldName="w_acc"
                    fieldValue="Kendor"
                    :checked="($aset->w_acc == 'Kendor') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class="q"  >6</td>
                <td class="q" align="left" colspan="4">KONDISI AKTUAL PROTEKSI DAN METERING</td>
            </tr> 
            <tr>
                <td class=""></td> 
                <td class="">1. LAMPU INDIKASI RELE READY</td> 
                <td class="">
                    <x-forms.checkbox fieldId="relay_ready-ready" :fieldLabel="__('app.ready')" 
                    fieldName="relay_ready"
                    fieldValue="Ready" :checked="($aset->relay_ready == 'Ready') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="relay_ready-alarm" :fieldLabel="__('app.alarm')" 
                    fieldName="relay_ready"
                    fieldValue="Alarm"
                    :checked="($aset->relay_ready == 'Alarm') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">2. DISPLAY RELE PROTEKSI</td> 
                <td class="">
                    <x-forms.checkbox fieldId="relay_display-normal" :fieldLabel="__('app.normal')" 
                    fieldName="relay_display"
                    fieldValue="Normal" :checked="($aset->relay_display == 'Normal') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="relay_display-blank" :fieldLabel="__('app.blank')" 
                    fieldName="relay_display"
                    fieldValue="Blank"
                        :checked="($aset->relay_display == 'Blank') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class="">
                    R : {{$aset->relay_mr ?? ''}} AMPERE 
                </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class=""></td> 
                <td class=""></td> 
                <td class=""></td>  
                <td class="">
                    S : {{$aset->relay_ms ?? ''}} AMPERE 
                </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class=""></td> 
                <td class=""></td> 
                <td class=""></td>  
                <td class="">
                    T : {{$aset->relay_mt ?? ''}} AMPERE 
                </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">3. PENUNJUKAN POWER METER</td> 
                <td class="">
                    <x-forms.checkbox fieldId="pm_display-normal" :fieldLabel="__('app.normal')" 
                    fieldName="pm_display"
                    fieldValue="Normal" :checked="($aset->pm_display == 'Normal') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="pm_display-blank" :fieldLabel="__('app.blank')" 
                    fieldName="pm_display"
                    fieldValue="Blank"
                        :checked="($aset->pm_display == 'Blank') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class="">
                    R : {{$aset->pm_mr ?? ''}} AMPERE 
                </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class=""></td> 
                <td class=""></td> 
                <td class=""></td>  
                <td class="">
                    S : {{$aset->pm_ms ?? ''}} AMPERE 
                </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class=""></td> 
                <td class=""></td> 
                <td class=""></td>  
                <td class="">
                    T : {{$aset->pm_mt ?? ''}} AMPERE 
                </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">4. KWH METER KUBIKEL</td> 
                <td class="">
                    <x-forms.checkbox fieldId="kwh_meter-normal" :fieldLabel="__('app.normal')" 
                    fieldName="kwh_meter"
                    fieldValue="Normal" :checked="($aset->kwh_meter == 'Normal') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="kwh_meter-blank" :fieldLabel="__('app.blank')" 
                    fieldName="kwh_meter"
                    fieldValue="Blank"
                        :checked="($aset->kwh_meter == 'Blank') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class="q"  >7</td>
                <td class="q" align="left" colspan="4">PANEL RTU</td>
            </tr> 
            <tr>
                <td class=""></td> 
                <td class="">1. KEBERSIHAN PANEL RTU</td> 
                <td class="">
                    <x-forms.checkbox fieldId="panel_rtu-bersih" :fieldLabel="__('app.bersih')" 
                    fieldName="panel_rtu"
                    fieldValue="Bersih" :checked="($aset->panel_rtu == 'Bersih') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="panel_rtu-kotor" :fieldLabel="__('app.kotor')" 
                    fieldName="panel_rtu"
                    fieldValue="Kotor"
                    :checked="($aset->panel_rtu == 'Kotor') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">2. DOOR CLOSE</td> 
                <td class="">
                    <x-forms.checkbox fieldId="door-ada" :fieldLabel="__('app.ada')" 
                    fieldName="door"
                    fieldValue="Ada" :checked="($aset->door == 'Ada') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="door-tada" :fieldLabel="__('app.tada')" 
                    fieldName="door"
                    fieldValue="Tidak Ada"
                    :checked="($aset->door == 'Tidak Ada') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">3. EXHAUST FAN</td> 
                <td class="">
                    <x-forms.checkbox fieldId="fan-ada" :fieldLabel="__('app.ada')" 
                    fieldName="fan"
                    fieldValue="Ada" :checked="($aset->fan == 'Ada') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="fan-tada" :fieldLabel="__('app.tada')" 
                    fieldName="fan"
                    fieldValue="Tidak Ada"
                    :checked="($aset->fan == 'Tidak Ada') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">4. LAMPU PANEL</td> 
                <td class="">
                    <x-forms.checkbox fieldId="lampu_panel-nyala" :fieldLabel="__('app.nyala')" 
                    fieldName="lampu_panel"
                    fieldValue="Nyala" :checked="($aset->lampu_panel == 'Nyala') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="lampu_panel-mati" :fieldLabel="__('app.mati')" 
                    fieldName="lampu_panel"
                    fieldValue="Mati"
                    :checked="($aset->lampu_panel == 'Mati') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">5. GROUNDING</td> 
                <td class="">
                    <x-forms.checkbox fieldId="grounding_rtu-ada" :fieldLabel="__('app.ada')" 
                    fieldName="grounding_rtu"
                    fieldValue="Ada" :checked="($aset->grounding_rtu == 'Ada') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="grounding_rtu-tada" :fieldLabel="__('app.tada')" 
                    fieldName="grounding_rtu"
                    fieldValue="Tidak Ada"
                    :checked="($aset->grounding_rtu == 'Tidak Ada') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">6. DISPLAY TEMPERATURE PANEL</td> 
                <td class="">
                    <x-forms.checkbox fieldId="temp_panel-baik" :fieldLabel="__('app.baik')" 
                    fieldName="temp_panel"
                    fieldValue="Baik" :checked="($aset->temp_panel == 'Baik') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="temp_panel-tbaik" :fieldLabel="__('app.tbaik')" 
                    fieldName="temp_panel"
                    fieldValue="Tidak Baik"
                    :checked="($aset->temp_panel == 'Tidak Baik') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class="q"  >8</td>
                <td class="q" align="left" colspan="4">RTU / CONCENTRATOR</td>
            </tr> 
            <tr>
                <td class=""></td> 
                <td class="">1. KEBERSIHAN PERALATAN</td> 
                <td class="">
                    <x-forms.checkbox fieldId="kebersihan-bersih" :fieldLabel="__('app.bersih')" 
                    fieldName="kebersihan"
                    fieldValue="Bersih" :checked="($aset->panel_rtu == 'Bersih') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="kebersihan-kotor" :fieldLabel="__('app.kotor')" 
                    fieldName="kebersihan"
                    fieldValue="Kotor"
                    :checked="($aset->kebersihan == 'Kotor') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">2. INDIKASI POWER ON</td> 
                <td class="">
                    <x-forms.checkbox fieldId="power_on-nyala" :fieldLabel="__('app.nyala')" 
                    fieldName="power_on"
                    fieldValue="Nyala" :checked="($aset->power_on == 'Nyala') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="power_on-mati" :fieldLabel="__('app.mati')" 
                    fieldName="power_on"
                    fieldValue="Mati"
                    :checked="($aset->power_on == 'Mati') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">3. INDIKASI LED TX/RX</td> 
                <td class="">
                    <x-forms.checkbox fieldId="led_txrx-kbrg" :fieldLabel="__('app.kbrg')" 
                    fieldName="led_txrx"
                    fieldValue="Kedip Bergatian" :checked="($aset->led_txrx == 'Kedip Bergatian') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="led_txrx-mnyl" :fieldLabel="__('app.mnyl')" 
                    fieldName="led_txrx"
                    fieldValue="Mati / Nyala"
                    :checked="($aset->led_txrx == 'Mati / Nyala') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
            <tr>
                <td class=""></td> 
                <td class="">4. KONDISI KABEL ETHERNET</td> 
                <td class="">
                    <x-forms.checkbox fieldId="ethernet-kencang" :fieldLabel="__('app.kencang')" 
                    fieldName="ethernet"
                    fieldValue="Kencang" :checked="($aset->ethernet == 'Kencang') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td> 
                <td class="">
                    <x-forms.checkbox fieldId="ethernet-kendor" :fieldLabel="__('app.kendor')" 
                    fieldName="ethernet"
                    fieldValue="Kendor"
                    :checked="($aset->ethernet == 'Kendor') ? 'checked' : ''">
                    </x-forms.checkbox>
                </td>
                <td class=""> </td>
            </tr>
        </tbody> 
    </table> 
    
    <p>&nbsp;</p>
    <span>KETERANGAN</span>
    <hr>
    <p id="notes">
      {{$aset->keterangan ??''}}
    </p>

</main>
</body>
</html>
