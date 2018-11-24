<?php
//header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
//header("Content-Disposition: attachment; filename=archivo.xls");
//header("Expires: 0");
//header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
//header("Cache-Control: private",false);
$n = 1;
$destino2 = "";
$encode = json_encode($pTotal[0]);
$pTotal_format = json_decode($encode);
//echo $pTotal_format->pTotal;
//echo count($reports);
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<meta charset="utf-8">
<html>
<table  border="1">
    <tr>
        <td colspan="15" align="center"><strong>TAXI TRECOJO</strong></td>

        {{--<td colspan="12" align="center">LISTADO DE SERVICIOS GENERALES</td>--}}
    </tr>
    <tr>
        <td colspan="15" align="center"><strong>LISTADO DE SERVICIOS GENERALES</strong></td>
    </tr>
    <tr>
        <td colspan="15"></td>
    </tr>
    <tr>
        <td colspan="15"></td>
    </tr>

    <tr>
        <th>N°</th>
        <th>FECHA</th>
        {{--<th>Hora</th>--}}
        <th>USUARIO</th>
        <th>DIRECCIÓN</th>
        <th>DESTINO 1</th>
        <th>DESTINO 2 Y 3</th>
        <th>MOVIL</th>
        <th>REALIZADO</th>
        <th>N° DE CUENTA</th>
        <th>VALOR</th>
        <th>PARQ.</th>
        <th>PEAJE/COUIER</th>
        <th>T.E S/.</th>
        <th>TOTAL</th>
        <th>OBS.</th>
    </tr>
    {{--</thead>--}}

    <tbody>
    @foreach( $reports as $report)
        <tr>
            <td>{{ $n }}</td>
            {{--                <td>{{  $report->date }}</td>--}}
            {{--<td>{{$report->first_name}}  {{$report->last_name}}</td>--}}
            <td>{{ $report->date_arrive }}</td>
            <td>{{$report->first_name}}  {{$report->last_name}}</td>
            <td>{{ $report->start_address }}</td>
            <td> {{ $report->end_address  }}</td>
            <td>
                {{--@if( $report->paradas != "")--}}
                <?php  $json = json_decode( $report->paradas) ?>
                @for($i = 0; $i < count($json); $i++)
                    <?php  $destino2.= $json[$i]  ?>
                    @if($i <  count($json) -1)
                        <?php $destino2 .= ","; ?>
                    @endif

                @endfor
                {{ $destino2 }}

            </td>
            <td>{{ $report->name_provider }} {{ $report->last_name_provider }}</td>
            <td>
                @if($report->is_paint == 0 || $report->is_paint == null)

                @else
                    {{ "X" }}
                @endif
            </td>
            <td>{{ $report->number_acount }}</td>
            <td>{{ $report->cost_amount }}</td>
            <td>{{ $report->parqueo }}</td>
            <td>{{ $report->peaje }}</td>
            <td>{{ $report->tespera }}</td>
            <td>S/. {{ $report->pTotal }}</td>
            <td>{{$report->obs}}</td>
            <?php $n++ ;$destino2 = "";?>

        </tr>
    @endforeach
    @if($n > count($reports))
        <tr>
            <td colspan="13" align="right"><strong>Total</strong></td>
            <td colspan="1"><strong>S/. {{$pTotal_format->pTotal}}</strong>  </td>
        </tr>
    @endif
    {{--    {{ $n }}--}}
    </tbody>
</table>
</html>
