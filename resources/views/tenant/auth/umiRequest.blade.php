<!DOCTYPE html>
<html>
<head>
    <title>Formulir Pendaftaran UMI</title>
</head>
<body>
    <p><span style="text-align: start; color: rgb(34, 34, 34); background-color: rgb(255, 255, 255); font-size: 14px; font-family: Calibri, sans-serif;">Dear Nobu Team,</span></p>
    <div style="text-align: start;color: rgb(34, 34, 34);background-color: rgb(255, 255, 255);font-size: small;"><span style="font-size: 14px; font-family: Calibri, sans-serif;"><br></span></div>
    <div style="text-align: start;color: rgb(34, 34, 34);background-color: rgb(255, 255, 255);font-size: small;"><span style="font-size: 14px; font-family: Calibri, sans-serif;">Terlampir tertera formulir permintaan approval UMI untuk usaha yang tertera sebagai berikut :</span></div>
    <p><span style="font-size: 14px;">&nbsp;</span></p>
    <table style="border: none;border-collapse: collapse;width:2610pt;">
        <tbody>
            <tr>
                <td style="padding:0px;color:white;font-size:15px;font-weight:700;font-style:normal;text-decoration:none;font-family:Calibri;text-align:center;vertical-align:middle;border:none;border-top:.5pt solid white;border-right:.5pt solid white;border-bottom:none;border-left:.5pt solid white;background:#2F5396;height:39.0pt;width:290pt;"><span style="font-size: 14px;">Nama Lengkap</span></td>
                <td style="padding:0px;color:white;font-size:15px;font-weight:700;font-style:normal;text-decoration:none;font-family:Calibri;text-align:center;vertical-align:middle;border:none;border-top:.5pt solid white;border-right:.5pt solid white;border-bottom:none;border-left:none;background:#2F5396;width:290pt;"><span style="font-size: 14px;">Nomor e-KTP</span></td>
                <td style="padding:0px;color:white;font-size:15px;font-weight:700;font-style:normal;text-decoration:none;font-family:Calibri;text-align:center;vertical-align:middle;border:none;border-top:.5pt solid white;border-right:.5pt solid white;border-bottom:none;border-left:none;background:#2F5396;width:290pt;"><span style="font-size: 14px;">Nomor Handphone</span></td>
                <td style="padding:0px;color:white;font-size:15px;font-weight:700;font-style:normal;text-decoration:none;font-family:Calibri;text-align:center;vertical-align:middle;border:none;border-top:.5pt solid white;border-right:.5pt solid white;border-bottom:none;border-left:none;background:#2F5396;width:290pt;"><span style="font-size: 14px;">Alamat Email</span></td>
                <td style="padding:0px;color:white;font-size:15px;font-weight:700;font-style:normal;text-decoration:none;font-family:Calibri;text-align:center;vertical-align:middle;border:none;border-top:.5pt solid white;border-right:.5pt solid white;border-bottom:none;border-left:none;background:#2F5396;width:290pt;"><span style="font-size: 14px;">Nama Usaha</span></td>
                <td style="padding:0px;color:white;font-size:15px;font-weight:700;font-style:normal;text-decoration:none;font-family:Calibri;text-align:center;vertical-align:middle;border:none;border-top:.5pt solid #2F5396;border-right:none;border-bottom:none;border-left:none;background:#2F5396;width:290pt;"><span style="font-size: 14px;">MCC - Jenis Usaha</span></td>
                <td style="padding:0px;color:white;font-size:15px;font-weight:700;font-style:normal;text-decoration:none;font-family:Calibri;text-align:center;vertical-align:middle;border:none;border-top:.5pt solid white;border-right:.5pt solid white;border-bottom:none;border-left:.5pt solid white;background:#2F5396;width:290pt;"><span style="font-size: 14px;">Alamat Usaha</span></td>
                <td style="padding:0px;color:white;font-size:15px;font-weight:700;font-style:normal;text-decoration:none;font-family:Calibri;text-align:center;vertical-align:middle;border:none;border-top:.5pt solid white;border-right:.5pt solid white;border-bottom:none;border-left:none;background:#2F5396;width:290pt;"><span style="font-size: 14px;">Kota/Kabupaten</span></td>
                <td style="padding:0px;color:white;font-size:15px;font-weight:700;font-style:normal;text-decoration:none;font-family:Calibri;text-align:center;vertical-align:middle;border:none;border-top:.5pt solid white;border-right:.5pt solid white;border-bottom:none;border-left:none;background:#2F5396;width:290pt;"><span style="font-size: 14px;">Kode pos</span></td>
            </tr>
            <tr>
                <td style="padding:0px;color:black;font-size:13px;font-weight:400;font-style:normal;text-decoration:none;font-family:Calibri;text-align:center;vertical-align:middle;border:.5pt solid white;background:#BDD7EE;height:15.0pt;"><span style="font-size: 14px;">{{ auth()->user()->name }}</span></td>
                <td style="padding:0px;color:black;font-size:13px;font-weight:400;font-style:normal;text-decoration:none;font-family:Calibri;text-align:center;vertical-align:middle;border:.5pt solid white;background:#BDD7EE;border-left:none;"><span style="font-size: 14px;">{{ auth()->user()->detail->no_ktp }}</span></td>
                <td style="padding:0px;color:black;font-size:13px;font-weight:400;font-style:normal;text-decoration:none;font-family:Calibri;text-align:center;vertical-align:middle;border:.5pt solid white;background:#BDD7EE;border-left:none;"><span style="font-size: 14px;">{{ auth()->user()->phone }}</span></td>
                <td style="padding:0px;color:#0563C1;font-size:13px;font-weight:400;font-style:normal;text-decoration:underline;font-family:Calibri;text-align:center;vertical-align:middle;border:.5pt solid white;background:#BDD7EE;border-left:none;"><span style="font-size: 14px;"><a href="mailto:{{ auth()->user()->email }}"><span style="color: rgb(5, 99, 193);">{{ auth()->user()->email }}</span></a></span></td>
                <td style="padding:0px;color:black;font-size:13px;font-weight:400;font-style:normal;text-decoration:none;font-family:Calibri;text-align:center;vertical-align:middle;border:.5pt solid white;background:#BDD7EE;border-left:none;"><span style="font-size: 14px;">{{$storeName}}</span></td>
                <td style="padding:0px;color:black;font-size:13px;font-weight:400;font-style:normal;text-decoration:none;font-family:Calibri;text-align:center;vertical-align:middle;border:.5pt solid white;background:#BDD7EE;border-left:none;"><span style="font-size: 14px;">{{$jenisUsaha}}</span></td>
                <td style="padding:0px;color:black;font-size:13px;font-weight:400;font-style:normal;text-decoration:none;font-family:Calibri;text-align:center;vertical-align:middle;border:.5pt solid white;background:#BDD7EE;border-left:none;"><span style="font-size: 14px;">{{$alamat}}</span></td>
                <td style="padding:0px;color:black;font-size:13px;font-weight:400;font-style:normal;text-decoration:none;font-family:Calibri;text-align:center;vertical-align:middle;border:.5pt solid white;background:#BDD7EE;border-left:none;"><span style="font-size: 14px;">{{$kabupaten}}</span></td>
                <td style="padding:0px;color:black;font-size:13px;font-weight:400;font-style:normal;text-decoration:none;font-family:Calibri;text-align:center;vertical-align:middle;border:.5pt solid white;background:#BDD7EE;border-left:none;"><span style="font-size: 14px;">{{$kodePos }}</span></td>
            </tr>
        </tbody>
    </table>
    <p><span style="font-size: 14px;"><br></span></p>
    <div style="text-align: start;color: rgb(34, 34, 34);background-color: rgb(255, 255, 255);font-size: small;"><span style="font-size: 14px; font-family: Calibri, sans-serif;">Demikian Email permohonan ini, dibuat dengan tanpa paksaan dari pihak manapun.</span></div>
    <div style="text-align: start;color: rgb(34, 34, 34);background-color: rgb(255, 255, 255);font-size: small;"><span style="font-size: 14px; font-family: Calibri, sans-serif;"><br></span></div>
    <div style="text-align: start;color: rgb(34, 34, 34);background-color: rgb(255, 255, 255);font-size: small;"><span style="font-size: 14px; font-family: Calibri, sans-serif;">Terima Kasih</span></div>
</body>
</html>