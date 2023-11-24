<?php

require_once __DIR__ . '/vendors/autoload.php';
require_once './pdfqueries.php';
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4-P',
    'orientation' => 'P'
]);


$html = "";

$html = '<table style="width: 100%">
        <tr>
            <td style="text-align: center"><h3>Collections</h3></td>
        </tr>
    </table>

    <table style="width: 100%; margin-top: 50px">
        <tr>
            <td><h3>Sold</h3></td>
        </tr>
    </table>
    <table style="width: 100%;margin-top:10px;" border="1">
        <thead>
            <tr>
                <td>#</td>
                <td>ItemCode</td>
                <td>Description</td>
                <td>Price</td>
                <td>Discount</td>
                <td>Date Paid</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                '.sold().'
            </tr>
        </tbody>
        
    </table>

    <table style="width: 100%; margin-top: 100px">
        <tr>
            <td><h3>Unsold</h3></td>
        </tr>
    </table>
    <table style="width: 100%;margin-top:10px;" border="1">
        <thead>
            <tr>
                <td>#</td>
                <td>ItemCode</td>
                <td>Description</td>
                <td>Price</td>
            </tr>
        </thead>
              
        <tbody>
            <tr>
                '.unsold().'
            </tr>
        </tbody>
    </table>

    <table style="width: 100%; margin-top: 100px">
        <tr>
            <td><h3>Damaged</h3></td>
        </tr>
    </table>
    <table style="width: 100%;margin-top:10px;" border="1">
        <thead>
            <tr>
                <td>#</td>
                <td>ItemCode</td>
                <td>Description</td>
                <td>Labeled as</td>
                <td>Price</td>
                <td>Date Paid</td>
            </tr>
        </thead>
        
        <tbody>
            <tr>
                '.damaged().'
            </tr>
        </tbody>
    </table>';



// $mpdf->WriteHTML($a);
// $a = file_get_contents(__DIR__ ."/attachment/collectionpdf.php");
$mpdf->WriteHTML($html);
$mpdf->Output();



?>