<?php
    session_start();
    include_once 'conexao.php';

    // Total do Contrato
        $result_vcontratado="SELECT SUM(valor_contratado) as valor_contratado FROM tbl_item WHERE status_item LIKE 'ativo' ";
        $resultado_vcontratado = $conn->prepare($result_vcontratado);
        $resultado_vcontratado->execute();                                   
        $row_vcontratado = $resultado_vcontratado->fetch(PDO::FETCH_ASSOC);
        $totalcontrato = $row_vcontratado['valor_contratado'];
        $ttlcontrato = number_format($totalcontrato, 2, ',', '.'); // <--- Valor Total Contrato com aditivos

    // Total Passagem Aérea Nacional
        $result_vaernac="SELECT valor_contratado FROM tbl_item WHERE status_item LIKE 'ativo' AND descricao LIKE 'Passagem Aérea Nacional'";
        $resultado_vaernac = $conn->prepare($result_vaernac);
        $resultado_vaernac->execute();
        $row_vaernac = $resultado_vaernac->fetch(PDO::FETCH_ASSOC);
        $aereonacional = $row_vaernac['valor_contratado'];
        $aernac = number_format($aereonacional, 2, ',', '.'); // <--- Total Contratado para Pass. Aérea Nacional

    // Total Passagem Aérea Internacional
        $result_vaerint="SELECT valor_contratado FROM tbl_item WHERE status_item LIKE 'ativo' AND descricao LIKE 'Passagem Aérea Internacional'";
        $resultado_vaerint = $conn->prepare($result_vaerint);
        $resultado_vaerint->execute();
        $row_vaerint = $resultado_vaerint->fetch(PDO::FETCH_ASSOC);
        $aerinternacional = $row_vaerint['valor_contratado'];
        $aerinter = number_format($aerinternacional, 2, ',', '.'); // <--- Total Contratado para Pass. Aérea Internacional

    // Total Passagem Rodoviária Nacional
        $result_vrodnac="SELECT valor_contratado FROM tbl_item WHERE status_item LIKE 'ativo' AND descricao LIKE 'Passagem Rodoviária Nacional'";
        $resultado_vrodnac = $conn->prepare($result_vrodnac);
        $resultado_vrodnac->execute();                     
        $row_vrodnac = $resultado_vrodnac->fetch(PDO::FETCH_ASSOC);
        $rodonacional = $row_vrodnac['valor_contratado'];
        $rodov = number_format($rodonacional, 2, ',', '.'); // <--- Total Contratado para Pass. Rodoviária

    // Total Seguro Viagem Internacional
        $result_vsegint="SELECT valor_contratado FROM tbl_item WHERE status_item LIKE 'ativo' AND descricao LIKE 'Seguro Viagem Internacional'";
        $resultado_vsegint = $conn->prepare($result_vsegint);
        $resultado_vsegint->execute();
        $row_vsegint = $resultado_vsegint->fetch(PDO::FETCH_ASSOC);
        $seginternacional = $row_vsegint['valor_contratado'];
        $seginter = number_format($seginternacional, 2, ',', '.'); // <--- Total Contratado para Seguro Viagem
    
    // Valor Total Pago
        $result_pago="SELECT SUM(valor_pago) as pago FROM tbl_pagamento WHERE status_pagamento LIKE 'ativo' ";
        $resultado_pago = $conn->prepare($result_pago);
        $resultado_pago->execute();
        $row_pago = $resultado_pago->fetch(PDO::FETCH_ASSOC);
        $totalpago = $row_pago['pago'];
        $ttlpago = number_format($totalpago, 2, ',', '.'); // <--- Total Pago

    //VALOR FATURADO GLOBAL
        // Soma Coluna Tarifa Voucher
            $result_tarifa="SELECT SUM(tarifa_voucher) + SUM(taxas_voucher) as total_voucher FROM tbl_passagem WHERE status_passagem LIKE 'ativo' ";
            $resultado_tarifa = $conn->prepare($result_tarifa);
            $resultado_tarifa->execute();
            $row_tarifa = $resultado_tarifa->fetch(PDO::FETCH_ASSOC);
            $somatrtx = $row_tarifa['total_voucher'];
        
        // Soma Total de Descontos R$
            $result_descvalor="SELECT SUM(desconto_valor) AS desconto_total FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE status_passagem LIKE 'ativo' ";
            $resultado_descvalor = $conn->prepare($result_descvalor);
            $resultado_descvalor->execute();
            $row_descvalor = $resultado_descvalor->fetch(PDO::FETCH_ASSOC);
        
        // Soma Total de Comissões R$
            $result_comvalor="SELECT SUM(comissao_valor) AS comissao_total FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE status_passagem LIKE 'ativo' ";
            $resultado_comvalor = $conn->prepare($result_comvalor);
            $resultado_comvalor->execute();
            $row_comvalor = $resultado_comvalor->fetch(PDO::FETCH_ASSOC);
        
        // Soma Total de Descontos %
            $result_descperc="SELECT SUM(desconto_percentual) AS descperc_total FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE status_passagem LIKE 'ativo' ";
            $resultado_descperc = $conn->prepare($result_descperc);
            $resultado_descperc->execute();
            $row_descperc = $resultado_descperc->fetch(PDO::FETCH_ASSOC);
        
        // Soma Total de Comissões %
            $result_comperc="SELECT SUM(comissao_percentual) AS comperc_total FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE status_passagem LIKE 'ativo' ";
            $resultado_comperc = $conn->prepare($result_comperc);
            $resultado_comperc->execute();
            $row_comperc = $resultado_comperc->fetch(PDO::FETCH_ASSOC);
        
        // Variáveis para cálculo final
            $descvalor = $row_descvalor['desconto_total'];
            $comvalor = $row_comvalor['comissao_total'];           
            $descperc = $row_descperc['descperc_total'];
            $comperc = $row_comperc['comperc_total'];
        
        // Cálculo Valor Total Apurado
            $comissaopercentual = (($somatrtx  * $comperc)/100) + $somatrtx;
            $descontopercentual = $comissaopercentual - (($comissaopercentual *  $descperc)/100);   
            $comissaoreais = $descontopercentual + $comvalor; 
            $vlrapurado = $comissaoreais - $descvalor;
            $vlrfaturado = number_format($vlrapurado, 2, ',', '.'); // <-- Valor total das compras exceto canceladas

    //VALOR FATURADO GLOBAL  POR UNIDADE
    // Soma Coluna Tarifa Voucher
        $result_trfuni="SELECT SUM(tarifa_voucher) + SUM(taxas_voucher) as total_trfuni
        FROM tbl_passagem 
        WHERE status_passagem LIKE 'ativo' AND unidade = 1";
        $resultado_trfuni = $conn->prepare($result_trfuni);
        $resultado_trfuni->execute();
        $row_trfuni = $resultado_trfuni->fetch(PDO::FETCH_ASSOC);
        $somatrtxuni = $row_trfuni['total_trfuni'];
    
    // Soma Total de Descontos R$
        $result_descvaloruni="SELECT SUM(desconto_valor) AS desconto_uni 
        FROM tbl_item
        LEFT JOIN tbl_passagem
        ON tbl_item.id_item = tbl_passagem.id_item
        WHERE status_passagem LIKE 'ativo' AND unidade = 1";
        $resultado_descvaloruni = $conn->prepare($result_descvaloruni);
        $resultado_descvaloruni->execute();
        $row_descvaloruni = $resultado_descvaloruni->fetch(PDO::FETCH_ASSOC);
        $descvaloruni = $row_descvaloruni['desconto_uni'];

    // Soma Total de Comissões R$
        $result_comvaloruni="SELECT SUM(comissao_valor) AS comissao_uni FROM tbl_item
        LEFT JOIN tbl_passagem
        ON tbl_item.id_item = tbl_passagem.id_item
        WHERE status_passagem LIKE 'ativo' AND unidade = 1";
        $resultado_comvaloruni = $conn->prepare($result_comvaloruni);
        $resultado_comvaloruni->execute();
        $row_comvaloruni = $resultado_comvaloruni->fetch(PDO::FETCH_ASSOC);
        $comvaloruni = $row_comvaloruni['comissao_uni'];

    // Soma Total de Descontos %
        $result_descpercuni="SELECT SUM(desconto_percentual) AS descperc_uni FROM tbl_item
        LEFT JOIN tbl_passagem
        ON tbl_item.id_item = tbl_passagem.id_item
        WHERE status_passagem LIKE 'ativo' AND unidade = 1";
        $resultado_descpercuni = $conn->prepare($result_descpercuni);
        $resultado_descpercuni->execute();
        $row_descpercuni = $resultado_descpercuni->fetch(PDO::FETCH_ASSOC);
        $descpercuni = $row_descpercuni['descperc_uni'];

    // Soma Total de Comissões %
        $result_compercuni="SELECT SUM(comissao_percentual) AS comperc_uni FROM tbl_item
        LEFT JOIN tbl_passagem
        ON tbl_item.id_item = tbl_passagem.id_item
        WHERE status_passagem LIKE 'ativo' AND unidade = 1";
        $resultado_compercuni = $conn->prepare($result_compercuni);
        $resultado_compercuni->execute();
        $row_compercuni = $resultado_compercuni->fetch(PDO::FETCH_ASSOC);
        $compercuni = $row_compercuni['comperc_uni'];
    
    // Cálculo Valor Total Apurado
        $comissaopercentualuni = (($somatrtxuni * $compercuni)/100) + $somatrtxuni;
        $descontopercentualuni = $comissaopercentualuni - (($comissaopercentualuni *  $descpercuni)/100);   
        $comissaoreaisuni = $descontopercentualuni + $comvaloruni; 
        $vlrapuradouni1 = $comissaoreaisuni - $descvaloruni;
        $vlrapuradouni2 = $vlrapurado - $vlrapuradouni1;
        $vlrfaturadouni1 = number_format($vlrapuradouni1, 2, ',', '.'); // <-- Valor total das compras DCC
        $vlrfaturadouni2 = number_format($vlrapuradouni2, 2, ',', '.'); // <-- Valor total das compras DAGR

    //VALOR TOTAL FATURADO PAN (Passagem Aérea Nacional)
        // Soma Coluna Tarifa Voucher
            $result_trfpan="SELECT SUM(tbl_passagem.tarifa_voucher) + SUM(tbl_passagem.taxas_voucher) as total_pan 
            FROM tbl_passagem 
            LEFT JOIN tbl_item ON tbl_passagem.id_item = tbl_item.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Aérea Nacional'";
            $resultado_trfpan = $conn->prepare($result_trfpan);
            $resultado_trfpan->execute();
            $row_trfpan = $resultado_trfpan->fetch(PDO::FETCH_ASSOC);
            $somatrfpan = $row_trfpan['total_pan']; // <-- tarifas e taxas PAN
        
        // Soma Total de Descontos R$ PAN
            $result_descvalorpan="SELECT SUM(desconto_valor) AS descvalor_pan 
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Aérea Nacional'";
            $resultado_descvalorpan = $conn->prepare($result_descvalorpan);
            $resultado_descvalorpan->execute();
            $row_descvalorpan = $resultado_descvalorpan->fetch(PDO::FETCH_ASSOC);
            $descvalorpan = $row_descvalorpan['descvalor_pan']; // <-- soma descontos monetarios PAN
        
        // Soma Total de Comissões R$ PAN
            $result_comvalorpan ="SELECT SUM(comissao_valor) AS comvalor_pan 
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Aérea Nacional'";
            $resultado_comvalorpan = $conn->prepare($result_comvalorpan);
            $resultado_comvalorpan->execute();
            $row_comvalorpan = $resultado_comvalorpan->fetch(PDO::FETCH_ASSOC);
            $comvalorpan = $row_comvalorpan['comvalor_pan']; // <-- soma comissoes monetarias PAN
        
        // Soma Total de Descontos % PAN
            $result_descpercpan="SELECT SUM(desconto_percentual) AS descperc_pan 
             FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Aérea Nacional'";
            $resultado_descpercpan = $conn->prepare($result_descpercpan);
            $resultado_descpercpan->execute();
            $row_descpercpan = $resultado_descpercpan->fetch(PDO::FETCH_ASSOC);
            $descpercpan = $row_descpercpan['descperc_pan'];    // <-- soma descontos percentuais PAN


        // Soma Total de Comissões % PAN
            $result_compercpan ="SELECT SUM(comissao_percentual) AS comperc_pan FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Aérea Nacional'";
            $resultado_compercpan = $conn->prepare($result_compercpan);
            $resultado_compercpan->execute();
            $row_compercpan = $resultado_compercpan->fetch(PDO::FETCH_ASSOC);
            $compercpan = $row_compercpan['comperc_pan'];
        
        // Cálculo Valor Total Apurado
            $comissaopercentualpan = (($somatrfpan  * $compercpan)/100) + $somatrfpan;
            $descontopercentualpan = $comissaopercentualpan - (($comissaopercentualpan *  $descpercpan)/100);   
            $comissaoreaispan = $descontopercentualpan + $comvalorpan; 
            $vlrapuradopan = $comissaoreaispan - $descvalorpan;
            $vlrfaturadopan = number_format($vlrapuradopan, 2, ',', '.'); // <-- Valor total das compras de PAN

    //VALOR TOTAL FATURADO PAI (Passagem Aérea Internacional)
        // Soma Coluna Tarifa Voucher
            $result_trfpai="SELECT SUM(tbl_passagem.tarifa_voucher) + SUM(tbl_passagem.taxas_voucher) as total_pai 
            FROM tbl_passagem 
            LEFT JOIN tbl_item ON tbl_passagem.id_item = tbl_item.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Aérea Internacional'";
            $resultado_trfpai = $conn->prepare($result_trfpai);
            $resultado_trfpai->execute();
            $row_trfpai = $resultado_trfpai->fetch(PDO::FETCH_ASSOC);
            $somatrfpai = $row_trfpai['total_pai']; // <-- tarifas e taxas PAI
        
        // Soma Total de Descontos R$ PAI
            $result_descvalorpai="SELECT SUM(desconto_valor) AS descvalor_pai 
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Aérea Internacional'";
            $resultado_descvalorpai = $conn->prepare($result_descvalorpai);
            $resultado_descvalorpai->execute();
            $row_descvalorpai = $resultado_descvalorpai->fetch(PDO::FETCH_ASSOC);
            $descvalorpai = $row_descvalorpai['descvalor_pai']; // <-- soma descontos monetarios PAI
        
        // Soma Total de Comissões R$ PAI
            $result_comvalorpai ="SELECT SUM(comissao_valor) AS comvalor_pai 
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Aérea Internacional'";
            $resultado_comvalorpai = $conn->prepare($result_comvalorpai);
            $resultado_comvalorpai->execute();
            $row_comvalorpai = $resultado_comvalorpai->fetch(PDO::FETCH_ASSOC);
            $comvalorpai = $row_comvalorpai['comvalor_pai']; // <-- soma comissoes monetarias PAI
        
        // Soma Total de Descontos % PAI
            $result_descpercpai="SELECT SUM(desconto_percentual) AS descperc_pai 
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Aérea Internacional'";
            $resultado_descpercpai = $conn->prepare($result_descpercpai);
            $resultado_descpercpai->execute();
            $row_descpercpai = $resultado_descpercpai->fetch(PDO::FETCH_ASSOC);
            $descpercpai = $row_descpercpai['descperc_pai'];    // <-- soma descontos percentuais PAI


        // Soma Total de Comissões % PAI
            $result_compercpai ="SELECT SUM(comissao_percentual) AS comperc_pai FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Aérea Internacional'";
            $resultado_compercpai = $conn->prepare($result_compercpai);
            $resultado_compercpai->execute();
            $row_compercpai = $resultado_compercpai->fetch(PDO::FETCH_ASSOC);
            $compercpai = $row_compercpai['comperc_pai'];
        
        // Cálculo Valor Total Apurado
            $comissaopercentualpai = (($somatrfpai  * $compercpai)/100) + $somatrfpai;
            $descontopercentualpai = $comissaopercentualpai - (($comissaopercentualpai *  $descpercpai)/100);   
            $comissaoreaispai = $descontopercentualpai + $comvalorpai; 
            $vlrapuradopai = $comissaoreaispai - $descvalorpai;
            $vlrfaturadopai = number_format($vlrapuradopai, 2, ',', '.'); // <-- Valor total das compras de PAI

    //VALOR TOTAL FATURADO RODO (Passagem Rodoviária)
        // Soma Coluna Tarifa Voucher
            $result_trfrodo="SELECT SUM(tbl_passagem.tarifa_voucher) + SUM(tbl_passagem.taxas_voucher) as total_rodo 
            FROM tbl_passagem 
            LEFT JOIN tbl_item ON tbl_passagem.id_item = tbl_item.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Rodoviária Nacional'";
            $resultado_trfrodo = $conn->prepare($result_trfrodo);
            $resultado_trfrodo->execute();
            $row_trfrodo = $resultado_trfrodo->fetch(PDO::FETCH_ASSOC);
            $somatrfrodo = $row_trfrodo['total_rodo']; // <-- tarifas e taxas RODO
        
        // Soma Total de Descontos R$ RODO
            $result_descvalorrodo="SELECT SUM(desconto_valor) AS descvalor_rodo 
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Rodoviária Nacional'";
            $resultado_descvalorrodo = $conn->prepare($result_descvalorrodo);
            $resultado_descvalorrodo->execute();
            $row_descvalorrodo = $resultado_descvalorrodo->fetch(PDO::FETCH_ASSOC);
            $descvalorrodo = $row_descvalorrodo['descvalor_rodo']; // <-- soma descontos monetarios RODO
        
        // Soma Total de Comissões R$ RODO
            $result_comvalorrodo ="SELECT SUM(comissao_valor) AS comvalor_rodo 
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Rodoviária Nacional'";
            $resultado_comvalorrodo = $conn->prepare($result_comvalorrodo);
            $resultado_comvalorrodo->execute();
            $row_comvalorrodo = $resultado_comvalorrodo->fetch(PDO::FETCH_ASSOC);
            $comvalorrodo = $row_comvalorrodo['comvalor_rodo']; // <-- soma comissoes monetarias RODO
        
        // Soma Total de Descontos % RODO
            $result_descpercrodo="SELECT SUM(desconto_percentual) AS descperc_rodo 
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Rodoviária Nacional'";
            $resultado_descpercrodo = $conn->prepare($result_descpercrodo);
            $resultado_descpercrodo->execute();
            $row_descpercrodo = $resultado_descpercrodo->fetch(PDO::FETCH_ASSOC);
            $descpercrodo = $row_descpercrodo['descperc_rodo'];    // <-- soma descontos percentuais RODO


        // Soma Total de Comissões % RODO
            $result_compercrodo ="SELECT SUM(comissao_percentual) AS comperc_rodo FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Rodoviária Nacional'";
            $resultado_compercrodo = $conn->prepare($result_compercrodo);
            $resultado_compercrodo->execute();
            $row_compercrodo = $resultado_compercrodo->fetch(PDO::FETCH_ASSOC);
            $compercrodo = $row_compercrodo['comperc_rodo'];
        
        // Cálculo Valor Total Apurado
            $comissaopercentualrodo = (($somatrfrodo  * $compercrodo)/100) + $somatrfrodo;
            $descontopercentualrodo = $comissaopercentualrodo - (($comissaopercentualrodo *  $descpercrodo)/100);   
            $comissaoreaisrodo = $descontopercentualrodo + $comvalorrodo; 
            $vlrapuradorodo = $comissaoreaisrodo - $descvalorrodo;
            $vlrfaturadorodo = number_format($vlrapuradorodo, 2, ',', '.'); // <-- Valor total das compras de RODO

    //VALOR TOTAL FATURADO SEGURO VIAGEM
        // Soma Coluna Tarifa Voucher SEG
            $result_trfseg ="SELECT SUM(tbl_passagem.tarifa_voucher) + SUM(tbl_passagem.taxas_voucher) as total_seg
            FROM tbl_passagem 
            LEFT JOIN tbl_item ON tbl_passagem.id_item = tbl_item.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Seguro Viagem Internacional'";
            $resultado_trfseg = $conn->prepare($result_trfseg);
            $resultado_trfseg->execute();
            $row_trfseg = $resultado_trfseg->fetch(PDO::FETCH_ASSOC);
            $somatrfseg = $row_trfseg['total_seg']; // <-- tarifas e taxas SEG
        
        // Soma Total de Descontos R$ SEG
            $result_descvalorseg="SELECT SUM(desconto_valor) AS descvalor_seg
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Seguro Viagem Internacional'";
            $resultado_descvalorseg = $conn->prepare($result_descvalorseg);
            $resultado_descvalorseg->execute();
            $row_descvalorseg = $resultado_descvalorseg->fetch(PDO::FETCH_ASSOC);
            $descvalorseg = $row_descvalorseg['descvalor_seg']; // <-- soma descontos monetarios SEG
        
        // Soma Total de Comissões R$ SEG
            $result_comvalorseg ="SELECT SUM(comissao_valor) AS comvalor_seg 
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Seguro Viagem Internacional'";
            $resultado_comvalorseg = $conn->prepare($result_comvalorseg);
            $resultado_comvalorseg->execute();
            $row_comvalorseg = $resultado_comvalorseg->fetch(PDO::FETCH_ASSOC);
            $comvalorseg = $row_comvalorseg['comvalor_seg']; // <-- soma comissoes monetarias SEG
        
        // Soma Total de Descontos % SEG
            $result_descpercseg="SELECT SUM(desconto_percentual) AS descperc_seg 
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Seguro Viagem Internacional'";
            $resultado_descpercseg = $conn->prepare($result_descpercseg);
            $resultado_descpercseg->execute();
            $row_descpercseg = $resultado_descpercseg->fetch(PDO::FETCH_ASSOC);
            $descpercseg = $row_descpercseg['descperc_seg'];    // <-- soma descontos percentuais SEG


        // Soma Total de Comissões % SEG
            $result_compercseg ="SELECT SUM(comissao_percentual) AS comperc_seg FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Seguro Viagem Internacional'";
            $resultado_compercseg = $conn->prepare($result_compercseg);
            $resultado_compercseg->execute();
            $row_compercseg = $resultado_compercseg->fetch(PDO::FETCH_ASSOC);
            $compercseg = $row_compercseg['comperc_seg'];
        
        // Cálculo Valor Total Apurado
            $comissaopercentualseg = (($somatrfseg  * $compercseg)/100) + $somatrfseg;
            $descontopercentualseg = $comissaopercentualseg - (($comissaopercentualseg *  $descpercseg)/100);   
            $comissaoreaisseg = $descontopercentualseg + $comvalorseg; 
            $vlrapuradoseg = $comissaoreaisseg - $descvalorseg;
            $vlrfaturadoseg = number_format($vlrapuradoseg, 2, ',', '.'); // <-- Valor total das compras de SEG


    //Saldo Atualizado do Contrato
        $saldocontrato = $totalcontrato - $vlrapurado;
        $sldcontrato = number_format($saldocontrato, 2, ',', '.'); // <--- Saldo Contrato

    //Valor Bloqueado (comprado mas ainda não pago)
        $valorbloqueado = $vlrapurado - $totalpago;                   
        $vlbloq = number_format($valorbloqueado, 2, ',', '.'); // <--- valor comprado mas ainda não pago. Bloqueia saldo mas pode vir a ser cancelado.






    //VALOR TOTAL FATURADO PAN POR GRAU (Passagem Aérea Nacional)
        // Soma Coluna Tarifa Voucher 1o grau
            $result_trfpan1="SELECT SUM(tbl_passagem.tarifa_voucher) + SUM(tbl_passagem.taxas_voucher) as total_pan1 
            FROM tbl_passagem 
            LEFT JOIN tbl_item ON tbl_passagem.id_item = tbl_item.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Aérea Nacional' AND tbl_passagem.grau LIKE '1º'";
            $resultado_trfpan1 = $conn->prepare($result_trfpan1);
            $resultado_trfpan1->execute();
            $row_trfpan1 = $resultado_trfpan1->fetch(PDO::FETCH_ASSOC);
            $somatrfpan1 = $row_trfpan1['total_pan1']; // <-- tarifas e taxas PAN 1 grau
        
        // Soma Total de Descontos R$ PAN 1o grau
            $result_descvalorpan1="SELECT SUM(desconto_valor) AS descvalor_pan1 
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Aérea Nacional' AND tbl_passagem.grau LIKE '1º'";
            $resultado_descvalorpan1 = $conn->prepare($result_descvalorpan1);
            $resultado_descvalorpan1->execute();
            $row_descvalorpan1 = $resultado_descvalorpan1->fetch(PDO::FETCH_ASSOC);
            $descvalorpan1 = $row_descvalorpan1['descvalor_pan1']; // <-- soma descontos monetarios PAN 1 grau
        
        // Soma Total de Comissões R$ PAN 1o grau
            $result_comvalorpan1 ="SELECT SUM(comissao_valor) AS comvalor_pan1 
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Aérea Nacional' AND tbl_passagem.grau LIKE '1º'";
            $resultado_comvalorpan1 = $conn->prepare($result_comvalorpan1);
            $resultado_comvalorpan1->execute();
            $row_comvalorpan1 = $resultado_comvalorpan1->fetch(PDO::FETCH_ASSOC);
            $comvalorpan1 = $row_comvalorpan1['comvalor_pan1']; // <-- soma comissoes monetarias PAN 1 grau
        
        // Soma Total de Descontos % PAN 1o grau
            $result_descpercpan1="SELECT SUM(desconto_percentual) AS descperc_pan1 
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Aérea Nacional' AND tbl_passagem.grau LIKE '1º'";
            $resultado_descpercpan1 = $conn->prepare($result_descpercpan1);
            $resultado_descpercpan1->execute();
            $row_descpercpan1 = $resultado_descpercpan1->fetch(PDO::FETCH_ASSOC);
            $descpercpan1 = $row_descpercpan1['descperc_pan1'];    // <-- soma descontos percentuais PAN 1 grau


        // Soma Total de Comissões % PAN 1o grau
            $result_compercpan1 ="SELECT SUM(comissao_percentual) AS comperc_pan1
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Aérea Nacional' AND tbl_passagem.grau LIKE '1º'";
            $resultado_compercpan1 = $conn->prepare($result_compercpan1);
            $resultado_compercpan1->execute();
            $row_compercpan1 = $resultado_compercpan1->fetch(PDO::FETCH_ASSOC);
            $compercpan1 = $row_compercpan1['comperc_pan1'];
        
        // Cálculo Valor Total Apurado
            $comissaopercentualpan1 = (($somatrfpan1  * $compercpan1)/100) + $somatrfpan1;
            $descontopercentualpan1 = $comissaopercentualpan1 - (($comissaopercentualpan1 *  $descpercpan1)/100);   
            $comissaoreaispan1 = $descontopercentualpan1 + $comvalorpan1; 
            $vlrapuradopan1 = $comissaoreaispan1 - $descvalorpan1;
            $vlrfaturadopan1 = number_format($vlrapuradopan1, 2, ',', '.'); // <-- Valor total das compras de PAN para o 1o grau.
            $vlrapuradopan2 = $vlrapuradopan - $vlrapuradopan1;
            $vlrfaturadopan2 = number_format($vlrapuradopan2, 2, ',', '.'); // <-- Valor total das compras de PAN para o 2o grau.

    //VALOR TOTAL FATURADO PAI POR GRAU (Passagem Aérea Internacional)
        // Soma Coluna Tarifa Voucher 1o grau
            $result_trfpai1="SELECT SUM(tbl_passagem.tarifa_voucher) + SUM(tbl_passagem.taxas_voucher) as total_pai1 
            FROM tbl_passagem 
            LEFT JOIN tbl_item ON tbl_passagem.id_item = tbl_item.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Aérea Internacional' AND tbl_passagem.grau LIKE '1º'";
            $resultado_trfpai1 = $conn->prepare($result_trfpai1);
            $resultado_trfpai1->execute();
            $row_trfpai1 = $resultado_trfpai1->fetch(PDO::FETCH_ASSOC);
            $somatrfpai1 = $row_trfpai1['total_pai1']; // <-- tarifas e taxas PAI 1o grau
        
        // Soma Total de Descontos R$ PAI 1o grau
            $result_descvalorpai1 ="SELECT SUM(desconto_valor) AS descvalor_pai1 
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Aérea Internacional' AND tbl_passagem.grau LIKE '1º'";
            $resultado_descvalorpai1 = $conn->prepare($result_descvalorpai1);
            $resultado_descvalorpai1->execute();
            $row_descvalorpai1 = $resultado_descvalorpai1->fetch(PDO::FETCH_ASSOC);
            $descvalorpai1 = $row_descvalorpai1['descvalor_pai1']; // <-- soma descontos monetarios PAI 1o grau
        
        // Soma Total de Comissões R$ PAI 1o grau
            $result_comvalorpai1 ="SELECT SUM(comissao_valor) AS comvalor_pai1 
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Aérea Internacional' AND tbl_passagem.grau LIKE '1º'";
            $resultado_comvalorpai1 = $conn->prepare($result_comvalorpai1);
            $resultado_comvalorpai1->execute();
            $row_comvalorpai1 = $resultado_comvalorpai1->fetch(PDO::FETCH_ASSOC);
            $comvalorpai1 = $row_comvalorpai1['comvalor_pai1']; // <-- soma comissoes monetarias PAI 1o grau
        
        // Soma Total de Descontos % PAI 1o grau
            $result_descpercpai1="SELECT SUM(desconto_percentual) AS descperc_pai1 
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Aérea Internacional' AND tbl_passagem.grau LIKE '1º'";
            $resultado_descpercpai1 = $conn->prepare($result_descpercpai1);
            $resultado_descpercpai1->execute();
            $row_descpercpai1 = $resultado_descpercpai1->fetch(PDO::FETCH_ASSOC);
            $descpercpai1 = $row_descpercpai1['descperc_pai1'];    // <-- soma descontos percentuais PAI 1o grau


        // Soma Total de Comissões % PAI 1o grau
            $result_compercpai1 ="SELECT SUM(comissao_percentual) AS comperc_pai1
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Aérea Internacional' AND tbl_passagem.grau LIKE '1º'";
            $resultado_compercpai1 = $conn->prepare($result_compercpai1);
            $resultado_compercpai1->execute();
            $row_compercpai1 = $resultado_compercpai1->fetch(PDO::FETCH_ASSOC);
            $compercpai1 = $row_compercpai1['comperc_pai1'];
        
        // Cálculo Valor Total Apurado 1o grau
            $comissaopercentualpai1 = (($somatrfpai1  * $compercpai1)/100) + $somatrfpai1;
            $descontopercentualpai1 = $comissaopercentualpai1 - (($comissaopercentualpai1 *  $descpercpai1)/100);   
            $comissaoreaispai1 = $descontopercentualpai1 + $comvalorpai1; 
            $vlrapuradopai1 = $comissaoreaispai1 - $descvalorpai1;
            $vlrfaturadopai1 = number_format($vlrapuradopai1, 2, ',', '.'); // <-- Valor total das compras de PAI 1o grau
            $vlrapuradopai2 = $vlrapuradopai - $vlrapuradopai1;
            $vlrfaturadopai2 = number_format($vlrapuradopai2, 2, ',', '.'); // <-- Valor total das compras de PAI 2o grau

    //VALOR TOTAL FATURADO RODO POR GRAU (Passagem Rodoviária)
        // Soma Coluna Tarifa Voucher 1o grau
            $result_trfrodo1="SELECT SUM(tbl_passagem.tarifa_voucher) + SUM(tbl_passagem.taxas_voucher) as total_rodo1 
            FROM tbl_passagem 
            LEFT JOIN tbl_item ON tbl_passagem.id_item = tbl_item.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Rodoviária Nacional' AND tbl_passagem.grau LIKE '1º'";
            $resultado_trfrodo1 = $conn->prepare($result_trfrodo1);
            $resultado_trfrodo1->execute();
            $row_trfrodo1 = $resultado_trfrodo1->fetch(PDO::FETCH_ASSOC);
            $somatrfrodo1 = $row_trfrodo1['total_rodo1']; // <-- tarifas e taxas RODO 1o grau
        
        // Soma Total de Descontos R$ RODO 1o grau
            $result_descvalorrodo1="SELECT SUM(desconto_valor) AS descvalor_rodo1 
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Rodoviária Nacional' AND tbl_passagem.grau LIKE '1º'";
            $resultado_descvalorrodo1 = $conn->prepare($result_descvalorrodo1);
            $resultado_descvalorrodo1->execute();
            $row_descvalorrodo1 = $resultado_descvalorrodo1->fetch(PDO::FETCH_ASSOC);
            $descvalorrodo1 = $row_descvalorrodo1['descvalor_rodo1']; // <-- soma descontos monetarios RODO 1o grau
        
        // Soma Total de Comissões R$ RODO 1o grau
            $result_comvalorrodo1 ="SELECT SUM(comissao_valor) AS comvalor_rodo1 
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Rodoviária Nacional' AND tbl_passagem.grau LIKE '1º'";
            $resultado_comvalorrodo1 = $conn->prepare($result_comvalorrodo1);
            $resultado_comvalorrodo1->execute();
            $row_comvalorrodo1 = $resultado_comvalorrodo1->fetch(PDO::FETCH_ASSOC);
            $comvalorrodo1 = $row_comvalorrodo1['comvalor_rodo1']; // <-- soma comissoes monetarias RODO 1o grau
        
        // Soma Total de Descontos % RODO 1o grau
            $result_descpercrodo1="SELECT SUM(desconto_percentual) AS descperc_rodo1 
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Rodoviária Nacional' AND tbl_passagem.grau LIKE '1º'";
            $resultado_descpercrodo1 = $conn->prepare($result_descpercrodo1);
            $resultado_descpercrodo1->execute();
            $row_descpercrodo1 = $resultado_descpercrodo1->fetch(PDO::FETCH_ASSOC);
            $descpercrodo1 = $row_descpercrodo1['descperc_rodo1'];    // <-- soma descontos percentuais RODO 1o grau


        // Soma Total de Comissões % RODO 1o grau
            $result_compercrodo1 ="SELECT SUM(comissao_percentual) AS comperc_rodo1 FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Passagem Rodoviária Nacional' AND tbl_passagem.grau LIKE '1º'";
            $resultado_compercrodo1 = $conn->prepare($result_compercrodo1);
            $resultado_compercrodo1->execute();
            $row_compercrodo1 = $resultado_compercrodo1->fetch(PDO::FETCH_ASSOC);
            $compercrodo1 = $row_compercrodo1['comperc_rodo1'];
        
        // Cálculo Valor Total Apurado 1o grau
            $comissaopercentualrodo1 = (($somatrfrodo1  * $compercrodo1)/100) + $somatrfrodo1;
            $descontopercentualrodo1 = $comissaopercentualrodo1 - (($comissaopercentualrodo1 *  $descpercrodo1)/100);   
            $comissaoreaisrodo1 = $descontopercentualrodo1 + $comvalorrodo1; 
            $vlrapuradorodo1 = $comissaoreaisrodo1 - $descvalorrodo1;
            $vlrfaturadorodo1 = number_format($vlrapuradorodo1, 2, ',', '.'); // <-- Valor total das compras de RODO 1o grau
            $vlrapuradorodo2 = $vlrapuradorodo - $vlrapuradorodo1;
            $vlrfaturadorodo2 = number_format($vlrapuradorodo2, 2, ',', '.'); // <-- Valor total das compras de RODO 2o grau

    //VALOR TOTAL FATURADO SEGURO VIAGEM POR GRAU
        // Soma Coluna Tarifa Voucher 1o grau
            $result_trfseg1="SELECT SUM(tbl_passagem.tarifa_voucher) + SUM(tbl_passagem.taxas_voucher) as total_seg1 
            FROM tbl_passagem 
            LEFT JOIN tbl_item ON tbl_passagem.id_item = tbl_item.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Seguro Viagem Internacional' AND tbl_passagem.grau LIKE '1º'";
            $resultado_trfseg1 = $conn->prepare($result_trfseg1);
            $resultado_trfseg1->execute();
            $row_trfseg1 = $resultado_trfseg1->fetch(PDO::FETCH_ASSOC);
            $somatrfseg1 = $row_trfseg1['total_seg1']; // <-- tarifas e taxas SEG 1o grau
        
        // Soma Total de Descontos R$ SEG 1o grau
            $result_descvalorseg1="SELECT SUM(desconto_valor) AS descvalor_seg1 
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Seguro Viagem Internacional' AND tbl_passagem.grau LIKE '1º'";
            $resultado_descvalorseg1 = $conn->prepare($result_descvalorseg1);
            $resultado_descvalorseg1->execute();
            $row_descvalorseg1 = $resultado_descvalorseg1->fetch(PDO::FETCH_ASSOC);
            $descvalorseg1 = $row_descvalorseg1['descvalor_seg1']; // <-- soma descontos monetarios SEG 1o grau
        
        // Soma Total de Comissões R$ SEG 1o grau
            $result_comvalorseg1 ="SELECT SUM(comissao_valor) AS comvalor_seg1 
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Seguro Viagem Internacional' AND tbl_passagem.grau LIKE '1º'";
            $resultado_comvalorseg1 = $conn->prepare($result_comvalorseg1);
            $resultado_comvalorseg1->execute();
            $row_comvalorseg1 = $resultado_comvalorseg1->fetch(PDO::FETCH_ASSOC);
            $comvalorseg1 = $row_comvalorseg1['comvalor_seg1']; // <-- soma comissoes monetarias SEG 1o grau
        
        // Soma Total de Descontos % SEG 1o grau
            $result_descpercseg1="SELECT SUM(desconto_percentual) AS descperc_seg1 
            FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Seguro Viagem Internacional' AND tbl_passagem.grau LIKE '1º'";
            $resultado_descpercseg1 = $conn->prepare($result_descpercseg1);
            $resultado_descpercseg1->execute();
            $row_descpercseg1 = $resultado_descpercseg1->fetch(PDO::FETCH_ASSOC);
            $descpercseg1 = $row_descpercseg1['descperc_seg1'];    // <-- soma descontos percentuais SEG 1o grau


        // Soma Total de Comissões % SEG 1o grau
            $result_compercseg1 ="SELECT SUM(comissao_percentual) AS comperc_seg1 FROM tbl_item
            LEFT JOIN tbl_passagem
            ON tbl_item.id_item = tbl_passagem.id_item
            WHERE tbl_passagem.status_passagem LIKE 'ativo' AND tbl_item.status_item iLIKE 'ativo' AND tbl_item.descricao iLIKE 'Seguro Viagem Internacional' AND tbl_passagem.grau LIKE '1º'";
            $resultado_compercseg1 = $conn->prepare($result_compercseg1);
            $resultado_compercseg1->execute();
            $row_compercseg1 = $resultado_compercseg1->fetch(PDO::FETCH_ASSOC);
            $compercseg1 = $row_compercseg1['comperc_seg1'];
        
        // Cálculo Valor Total Apurado 1o grau
            $comissaopercentualseg1 = (($somatrfseg1  * $compercseg1)/100) + $somatrfseg1;
            $descontopercentualseg1 = $comissaopercentualseg1 - (($comissaopercentualseg1 *  $descpercseg1)/100);   
            $comissaoreaisseg1 = $descontopercentualseg1 + $comvalorseg1; 
            $vlrapuradoseg1 = $comissaoreaisseg1 - $descvalorseg1;
            $vlrfaturadoseg1 = number_format($vlrapuradoseg1, 2, ',', '.'); // <-- Valor total de Seguro Viagem 1o grau
            $vlrapuradoseg2 = $vlrapuradoseg - $vlrapuradoseg1;
            $vlrfaturadoseg2 = number_format($vlrapuradoseg2, 2, ',', '.'); // <-- Valor total de Seguro Viagem 2o grau

    // SALDOS ITENS
        $saldoPan =  $aereonacional - $vlrapuradopan;
        $sldPan = number_format($saldoPan, 2, ',', '.'); // <--- Saldo PAN.

        $saldoPai = $aerinternacional - $vlrapuradopai;
        $sldPai =  number_format($saldoPai, 2, ',', '.'); // <--- Saldo PAI.

        $saldoRodo = $rodonacional - $vlrapuradorodo;
        $sldRodo = number_format($saldoRodo, 2, ',', '.'); // <--- Saldo RODO.

        $saldoSeg = $seginternacional - $vlrapuradoseg;
        $sldSeg = number_format($saldoSeg, 2, ',', '.'); // <--- Saldo SEG.

    
?>
<!DOCTYPE html>

<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Cadastro de Viagem</title>
    <link rel="shortcut icon" href="assets/img/icon.png" type="image/png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/sidebar.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>

<body>
    <header>
        <nav class="navbar fixed-top navbar-expand-md navbar-dark">
            <div class="header">
                <div class="logo">
                    <img src="assets/img/logobco.png" type="image/png" width=80>
                </div>
                <div class="session">
                    <a id="session">
                        <i class="fas fa-user"></i>
                        <?php
                        if (!empty($_SESSION['id_usuario'])) {
                            echo $_SESSION['nome_completo'] . " - " . $_SESSION['matricula'];
                        } else {
                            header("Location: index.php");
                        }
                        ?>
                    </a>
                </div>
                <!--Logo-->
                <div class="buttonHamb">
                    <!--Menu Hamburger-->
                    <button class="navbar-toggler" data-toggle="collapse" data-target="#nav-target">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <!--navegação-->
                <div class="collapse navbar-collapse" id="nav-target">
                    <ul class="navbar-nav ml-auto">

                        <!-- início -->
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="menu.php" id="navbarSupportedContent" role="button"
                                aria-haspopup="true" aria-expanded="false" style="margin-right:.5rem">
                                <i class="fas fa-home"></i>
                                Início
                            </a>
                        </li>

                        <!-- Menu Cadastrar -->
                        <?php
                        if ($_SESSION['funcao'] < 3) {
                            echo '                            
                                        <li class="nav-item dropdown">                            
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarSupportedContent" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Cadastrar
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="cadviagem.php">Viagem</a>
                                                <a class="dropdown-item" href="cadpassagem.php">Passagem</a>
                                                <a class="dropdown-item" href="cadpessoa.php">Passageiro</a>
                                    ';
                        }
                        if ($_SESSION['funcao'] == 1) {
                            echo '
                                                <a class="dropdown-item" href="cadcontrato.php">Contrato</a>
                                                <a class="dropdown-item" href="cadaditivo.php">Aditivo</a>
                                    ';
                        }
                        if ($_SESSION['funcao'] < 3) {
                            echo '
                                            </div>
                                        </li>
                                        
                                        <!-- Menu Editar -->

                                        <li class="nav-item dropdown">                            
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarSupportedContent" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Editar
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="editviagem.php">Viagem</a>
                                                <a class="dropdown-item" href="editpassagem.php">Passagem</a>
                                                <a class="dropdown-item" href="editpessoa.php">Passageiro</a>
                                    ';
                        }
                        if ($_SESSION['funcao'] == 1) {

                            echo '
                                                <a class="dropdown-item" href="editcontrato.php">Contrato</a>
                                                <a class="dropdown-item" href="edititem.php">Item de Contrato</a>
                                                <a class="dropdown-item" href="editaditivo.php">Aditivo</a>
                                    ';
                        }
                        if ($_SESSION['funcao'] < 3) {
                            echo '
                                            </div>
                                        </li>
                                    ';
                        }
                        ?>
                        <?php
                        if ($_SESSION['funcao'] < 3) {
                            echo '
                                        <!--Menu Pagamento -->
                                        <li class="nav-item dropdown">                            
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarSupportedContent" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Pagamento
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="cadpagamento.php">Lançar</a>
                                                <a class="dropdown-item" href="editpagamento.php">Alterar</a>
                                            </div>
                                        </li>
                                    ';
                        }
                        ?>

                        <!-- Menu Consultar -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarSupportedContent" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Consultar
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="consultar_viagem.php">Viagem</a>
                                <a class="dropdown-item" href="consulpassagem.php">Passagem</a>
                                <a class="dropdown-item" href="cadpessoa.php">Passageiro</a>
                                <a class="dropdown-item" href="consulta_pagamento.php">Pagamento</a>
                            </div>
                        </li>

                        <!-- Menu Administrador -->
                        <?php
                        if ($_SESSION['funcao'] < 3) {
                            echo '
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Administrador
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-left text-right" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="cadcidade.php">Cadastrar Cidade</a>
                                    ';
                        }
                        if ($_SESSION['funcao'] == 1) {
                            echo '
                                                <a class="dropdown-item" href="cadusuario.php">Cadastrar Usuário</a>
                                                <a class="dropdown-item" href="cadcontrato.php">Cadastrar Contrato</a>
                                                <a class="dropdown-item" href="cadaditivo.php">Cadastrar Aditivo</a>
                                    ';
                        }
                        ?>
                        <?php
                        if ($_SESSION['funcao'] < 3) {
                            echo '
                                            </div>							
                                        </li>
                                    ';
                        }
                        ?>
                        <!-- Menu Sair -->
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="sair.php">
                                <span>Sair</span>
                                <i class="fas fa-sign-out-alt"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <section class="col-md-auto">
        <div class="dashboard">
            <!-- TÍTULOS KPIs -->
                <div class="row">
                    <div class="kpi-head-main">Contrato</div>
                    <div class="kpi-head">Passagem Aérea Nacional</div>
                    <div class="kpi-head">Passagem Aérea Internacional</div>
                    <div class="kpi-head">Passagem Rodoviária Nacional</div>
                    <div class="kpi-head">Seguro Viagem Internacional</div>
                </div>
            <!-- KPIs UTILIZADOS E CONTRATADOS -->
                <div class="row">                    
                    <!-- KPI Valor Total Contrato -->
                    <div class="kpi-md-main">
                        <span style="font-size: small; color: #123141">Total Contratado:</span> R$ <?=$ttlcontrato;?><br>
                        <span style="font-size: small; color: #123141">Total Utilizado:</span> <span style="color: red; font-size: medium">R$ <?=$vlrfaturado;?></span>
                    </div>

                    <!-- KPI Valor Total Passagens Aéreas Nacionais -->
                    <div class="kpi-md">
                        <span style="font-size: small; color: #123141">Contratado:</span> R$ <?=$aernac;?><br>
                        <span style="font-size: small; color: #123141">Utilizado:</span> <span style="color: red; font-size: medium">R$ <?=$vlrfaturadopan;?></span>
                    </div>

                    <!-- KPI Valor Total Passagens Aéreas Internacionais -->
                    <div class="kpi-md">
                        <span style="font-size: small; color: #123141">Contratado:</span> R$ <?=$aerinter;?><br>
                        <span style="font-size: small; color: #123141">Utilizado:</span> <span style="color: red; font-size: medium">R$ <?=$vlrfaturadopai;?></span>
                    </div>

                    <!-- KPI Valor Total Passagem Rodoviária        -->
                    <div class="kpi-md">
                        <span style="font-size: small; color: #123141">Contratado:</span> R$ <?=$rodov;?><br>
                        <span style="font-size: small; color: #123141">Utilizado:</span> <span style="color: red; font-size: medium">R$ <?=$vlrfaturadorodo;?></span>
                    </div>

                    <!-- KPI Valor Total Seguro Viagem -->
                    <div class="kpi-md">
                        <span style="font-size: small; color: #123141">Contratado:</span> R$ <?=$seginter;?><br>
                        <span style="font-size: small; color: #123141">Utilizado:</span> <span style="color: red; font-size: medium">R$ <?=$vlrfaturadoseg;?></span>
                    </div>
                </div>
            <!-- KPIs SALDOS -->
                <div class="row">                    
                    <!-- KPI Saldo Passagens Aéreas Nacionais -->
                    <div class="kpi-big-main"><a style="font-size: small; color: #123141">Saldo Disponível</a><br>R$ <?=$sldcontrato;?></div>

                    <!-- KPI Saldo Passagens Aéreas Nacionais -->
                    <div class="kpi-big"><a style="font-size: small; color: #123141">Saldo Disponível</a><br>R$ <?=$sldPan;?></div>

                    <!-- KPI Saldo Passagens Aéreas Internacionais -->
                    <div class="kpi-big"><a style="font-size: small; color: #123141">Saldo Disponível</a><br>R$ <?=$sldPai;?></div>

                    <!-- KPI Saldo Passagem Rodoviária        -->
                    <div class="kpi-big"><a style="font-size: small; color: #123141">Saldo Disponível</a><br>R$ <?=$sldRodo;?></div>

                    <!-- KPI Valor Total Seguro Viagem -->
                    <div class="kpi-big"><a style="font-size: small; color: #123141">Saldo Disponível</a><br>R$ <?=$sldSeg;?></div>
                </div>
            <!-- GRÁFICOS -->
                <div class="row">
                    <!-- Gráfico Pizza Percentual Contrato -->
                    <div class="col-md-2.3">
                        <canvas id="grafico_contrato">
                            <script>
                            var ctx = document.getElementById('grafico_contrato').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    labels: ['Utilizado %','Diponível %'],
                                    datasets: [{
                                        label: 'Evolução do Contrato',
                                        barPercentage: 1,
                                        barThickness: 2,
                                        maxBarThickness: 3,
                                        minBarLength: 2,
                                        data: [<?= round(($vlrapurado * 100 / $totalcontrato), 2);?>,<?= round(($saldocontrato * 100 / $totalcontrato), 2);?>],
                                        backgroundColor: [
                                            
                                            'rgba(255, 99, 132, 0.8)',
                                            'rgba(75, 192, 192, 0.8)',
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(75, 192, 192, 1)',
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                    }
                                }
                            });
                            </script>
                        </canvas>
                    </div>
                    <!-- Gráfico Barra Valor PAN por Grau -->
                    <div class="col-md-2.3">
                        <canvas id="grafico_pan_grau">
                            <script>
                            var ctx = document.getElementById('grafico_pan_grau').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: ['1º Grau R$','2º Grau R$'],
                                    datasets: [{
                                        label: 'Passagem Aérea Nacional',
                                        barPercentage: 1,
                                        barThickness: 2,
                                        maxBarThickness: 3,
                                        minBarLength: 2,
                                        data: [<?= $vlrapuradopan1;?>,<?= $vlrapuradopan2;?>],
                                        backgroundColor: [
                                            
                                            'rgba(74, 174, 154, 0.8)',
                                            'rgba(238, 177, 52, 0.8)',
                                        ],
                                        borderColor: [
                                            'rgba(74, 174, 154, 1)',
                                            'rgba(238, 177, 52, 1)',
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                    }
                                }
                            });
                            </script>
                        </canvas>
                    </div>
                    <!-- Gráfico Barra Valor PAI por Grau -->
                    <div class="col-md-2.3">
                        <canvas id="grafico_pai_grau">
                            <script>
                            var ctx = document.getElementById('grafico_pai_grau').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: ['1º Grau R$','2º Grau R$'],
                                    datasets: [{
                                        label: 'Passagem Aérea Internacional',
                                        barPercentage: 1,
                                        barThickness: 2,
                                        maxBarThickness: 3,
                                        minBarLength: 2,
                                        data: [<?= $vlrapuradopai1;?>,<?= $vlrapuradopai2;?>],
                                        backgroundColor: [
                                            
                                            'rgba(74, 174, 154, 0.8)',
                                            'rgba(238, 177, 52, 0.8)',
                                        ],
                                        borderColor: [
                                            'rgba(74, 174, 154, 1)',
                                            'rgba(238, 177, 52, 1)',
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                    }
                                }
                            });
                            </script>
                        </canvas>
                    </div>
                    <!-- Gráfico Barra Valor RODO por Grau -->
                    <div class="col-md-2.3">
                        <canvas id="grafico_rodo_grau">
                            <script>
                            var ctx = document.getElementById('grafico_rodo_grau').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: ['1º Grau R$','2º Grau R$'],
                                    datasets: [{
                                        label: 'Passagem Rodoviária Nacional',
                                        barPercentage: 1,
                                        barThickness: 2,
                                        maxBarThickness: 3,
                                        minBarLength: 2,
                                        data: [<?= $vlrapuradorodo1;?>,<?= $vlrapuradorodo2;?>],
                                        backgroundColor: [
                                            
                                            'rgba(74, 174, 154, 0.8)',
                                            'rgba(238, 177, 52, 0.8)',
                                        ],
                                        borderColor: [
                                            'rgba(74, 174, 154, 1)',
                                            'rgba(238, 177, 52, 1)',
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                    }
                                }
                            });
                            </script>
                        </canvas>
                    </div>
                    <!-- Gráfico Barra Valor SEG por Grau -->
                    <div class="col-md-2.3">
                        <canvas id="grafico_seg_grau">
                            <script>
                            var ctx = document.getElementById('grafico_seg_grau').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: ['1º Grau R$','2º Grau R$'],
                                    datasets: [{
                                        label: 'Seguro Viagem Internacional',
                                        barPercentage: 1,
                                        barThickness: 2,
                                        maxBarThickness: 3,
                                        minBarLength: 2,
                                        data: [<?= $vlrapuradoseg1;?>,<?= $vlrapuradoseg2;?>],
                                        backgroundColor: [
                                            
                                            'rgba(74, 174, 154, 0.8)',
                                            'rgba(238, 177, 52, 0.8)',
                                        ],
                                        borderColor: [
                                            'rgba(74, 174, 154, 1)',
                                            'rgba(238, 177, 52, 1)',
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                    }
                                }
                            });
                            </script>
                        </canvas>
                    </div>

                </div>
                <div class="row">
                    <!-- Gráfico Barra Valor SEG por Grau -->
                    <div class="col-md-2.3">
                        <canvas id="grafico_compunidade">
                            <script>
                            var ctx = document.getElementById('grafico_compunidade').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'doughnut',
                                data: {
                                    labels: ['DCC','DAGR'],
                                    datasets: [{
                                        label: 'Faturado por Unidade',
                                        barPercentage: 1,
                                        barThickness: 2,
                                        maxBarThickness: 3,
                                        minBarLength: 2,
                                        data: [<?= $vlrapuradouni1;?>,<?= $vlrapuradouni2;?>],
                                        backgroundColor: [
                                            
                                            'rgba(18, 49, 65, 0.8)',
                                            'rgba(235, 85, 59, 0.8)',


                                        ],
                                        borderColor: [
                                            'rgba(18, 49, 65, 1)',
                                            'rgba(235, 85, 59, 1)',
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                    }
                                }
                            });
                            </script>
                        </canvas>
                    </div>
                    <div class="painel">
                        <table class="table table-striped">
                            <tr>
                                <th style="font-size: medium; font-weight: 500, text-align: center">INDICADOR</th>
                                <th style="font-size: medium; font-weight: 500, text-align: center">TOTAL</th>
                            </tr>
                            <tr>
                                <td style="font-size: medium; font-weight: 500">Total Comprado:</td>
                                <td style="font-size: medium; font-weight: 500; color: blue">R$ <?=$vlrfaturado;?></td>
                            </tr>
                            <tr>
                                <td style="font-size: medium; font-weight: 500">Total Pago:</td>
                                <td style="font-size: medium; font-weight: 500; color: blue">R$ <?=$ttlpago;?></td>
                            </tr>
                            <tr>
                            <td style="font-size: medium; font-weight: 500">Bloqueado:</td>
                                <td style="font-size: medium; font-weight: 500; color: blue">R$ <?=$vlbloq;?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                    <!-- 
                        Valor Total Pago '.$ttlpago.'
 
                        Valor Bloqueado '.$vlbloq.'

                        Valor Total Faturado '.$vlrfaturado.'        
                        
                        Valor Total Faturado DCC $vlrfaturadouni1
                        Valor Total Faturado DAGR $vlrfaturadouni2
                        
                    -->

            </div>


        </div>
    </section>
    <footer>
        <div class="footer">©️ Tribunal de Justiça do Estado do Paraná - Sistema de Controle de Passagens
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
    <script src="assets/css/bootstrap.min.css"></script>
</body>

</html>