<html>
    <head>
        <title>Cetak Nota</title>
        <style>
            @page { margin: 0 }
            body { margin: 0; font-size:10px;font-family: monospace;}
            td, th { font-size:10px; }
            .sheet {
                margin: 0;
                overflow: hidden;
                position: relative;
                box-sizing: border-box;
                page-break-after: always;
            }

            /** Paper sizes **/
            body.struk        .sheet { width: 58mm; }
            body.struk .sheet        { padding: 2mm; }

            .txt-left { text-align: left;}
            .txt-center { text-align: center;}
            .txt-right { text-align: right;}

            /** For screen preview **/
            @media screen {
                body { background: #e0e0e0;font-family: monospace; }
                .sheet {
                    background: white;
                    box-shadow: 0 .5mm 2mm rgba(0,0,0,.3);
                    margin: 5mm;
                }
            }

            /** Fix for Chrome issue #273306 **/
            @media print {
                body { font-family: monospace; }
                body.struk                 { width: 58mm; text-align: left;}
                body.struk .sheet          { padding: 2mm; }
                .txt-left { text-align: left;}
                .txt-center { text-align: center;}
                .txt-right { text-align: right;}
            }
            .harga{
                border-collapse: collapse;
            }
            .harga thead tr th{
                border-bottom: 1px solid #000000;
            }

            .harga tfoot tr td{
                border-top: 1px solid #000000;
            }

            table.harga td { width: 30px; overflow-wrap: break-word;}
            table.harga { table-layout: fixed; }
        </style>
    </head>
    <body class="struk">
        <section class="sheet">
        <?php
            echo '<table cellpadding="0" cellspacing="0" style="width:100%">
                    <tr>
                        <td align="center" style="text-align: center;">Laundry KP-Gotong Royng SDA</td>
                    </tr>
                    <tr>
                        <td align="center" style="text-align: center;">Jl. Suka Maju No. 45 Sidoarjo Waru</td>
                    </tr>
                    <tr>
                        <td align="center" style="text-align: center;">Telp: 0803454394540</td>
                    </tr>
                </table>';
            echo "<br>";
            echo(str_repeat("=", 38)."<br/>");
        ?>
        <table cellpadding="0" cellspacing="0" style="width:100%">
            <tr>
                <td align="left" class="txt-left">Nota&nbsp;</td>
                <td align="left" class="txt-left">:</td>
                <td align="left" class="txt-left">&nbsp;12345678</td>
            </tr>
            <tr>
                <td align="left" class="txt-left">Kasir</td>
                <td align="left" class="txt-left">:</td>
                <td align="left" class="txt-left">&nbsp;Amar Wibianto</td>
            </tr>
            <tr>
                <td align="left" class="txt-left">Tgl.&nbsp;</td>
                <td align="left" class="txt-left">:</td>
                <td align="left" class="txt-left">&nbsp;04-03-2024</td>
            </tr>
            <tr>
                <td align="left" class="txt-left">Jadwal Ambil&nbsp;</td>
                <td align="left" class="txt-left">:</td
                <td align="left" class="txt-left">&nbsp;05-03-2024</td>
            </tr>
            <tr>
                <td align="left" colspan="3" class="txt-left" style="word-wrap: break-word">[123]Amar Wibianto</td>
            </tr>
        </table>
        <br/>
            
        
                <table class="harga" id="cart-table">    
                    <thead>
                        <tr class="heading">
                            <th class="txt-left">Paket</th>
                            <th class="txt-left">Harga</th>
                            <th class="txt-left">Tambahan</th>
                            <th class="txt-left">Diskon</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="200" style="width: 200px;">Jumbo</td>
                            <td width="300" style="width: 300px;">Rp. 1000.000</td>
                            <td width="300" style="width: 300px;">Rp. 0</td>
                            <td width="10" style="width: 10px;">2%</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot
                </table>
                <table class="harga" id="cart-table" style="width: 100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th align=right" style="text-align: right;"></th>
                        </tr>
                    </thead> 
                    <tbody>
                        <tr>
                            <td colspan="2">Berat</td>
                            <td colspan="1">:</td>
                            <td colspan="3" align=right" style="text-align: right;">5 Kg</td>
                        </tr>
                        <tr>
                            <td colspan="2">Banyak</td>
                            <td colspan="1">:</td>
                            <td colspan="3"style="text-align: right;">10</td>
                        </tr>
                        <tr>
                            <td colspan="2">Jenis</td>
                            <td colspan="1">:</td>
                            <td colspan="3"style="text-align: right;">Jaket</td>
                        </tr>
                        <tr>
                            <td colspan="2">Harga</td>
                            <td colspan="1">:</td>
                            <td colspan="3" style="text-align: right;">Rp. 1000.0000</td>
                        </tr>
                        <tr>
                            <td colspan="2">Harga Total</td>
                            <td colspan="1">:</td>
                            <td colspan="3" style="text-align: right;">Rp. 1.100.000</td>
                        </tr>
                        <tr>
                            <td colspan="2">Bayar</td>
                            <td colspan="1">:</td>
                            <td colspan="3" style="text-align: right;">Rp. 1.000.0000</td>
                        </tr>
                        <tr>
                            <td colspan="2">Kembali</td>
                            <td colspan="1">:</td>
                            <td colspan="3" style="text-align: right;">Rp. 100.000</td>
                        </tr>
                        <tr>
                            <td colspan="2">Status</td>
                            <td colspan="1">:</td>
                            <td colspan="3" style="text-align: right;">Selesai</td>
                        </tr>
                    </tbody>
                </table>
                <br><br><br>
                <?php
                                $footer = 'Terima kasih atas kunjungan anda';
            $starSpace = ( 32 - strlen($footer) ) / 2;
            $starFooter = str_repeat('*', $starSpace+1);
            echo($starFooter. '&nbsp;'.$footer . '&nbsp;'. $starFooter."<br/><br/><br/><br/>");
            echo '<p>&nbsp;</p>'; 
                ?>
                
        </section>
        <script>
            var lama = 1000;
            t = null;
            function printOut(){
                window.print();
                t = setTimeout("self.close()",lama);
            }
        </script>
    </body>
</html>