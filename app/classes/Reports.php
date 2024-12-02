<?php
namespace app\classes;
use Dompdf\Dompdf;


class Reports
{
    public function __construct()
    {
    }

    public function generatePDF($type,$dados, $dataInicio, $dataFim)
    {    
        $dataInicio = new \DateTime($dataInicio);
        $dataFim = new \DateTime($dataFim);
        $totalRecebido = 0;
        $dadosTabela = '';

        foreach ($dados as $linha) {
            $dadosTabela .= "
            <tr>
                <td>{$linha->getDateSchedule()->format('d-m-Y')}</td>
                <td>{$linha->getStatus()}</td>
                <td>{$linha->getStartTime()->format('H:i')}</td>
                <td>{$linha->getEndTime()->format('H:i')}</td>
                <td>{$linha->getClient()->getName()}</td>
                <td>R$ " . number_format($linha->getTotalPaid(), 2, ',', '.') . "</td>
            </tr>";
            $totalRecebido += $linha->getTotalPaid();
        }

        $html = file_get_contents(__DIR__ .'../../views/templateRelatorio.html');
       
        //TODO header adaptavel a tabela
        $headerTable = "  <tr>
                <th>Data</th>
                <th>Status</th>
                <th>Hora Início</th>
                <th>Hora Fim</th>
                <th>Cliente</th>
                <th>Preço</th>
            </tr>";
        $conteudo_pdf = str_replace(
            ['{{TITLE}}', '{{DATA_INICIO}}','{{DATA_FIM}}','{{TOTAL_RECEBIDO}}','{{DADOS_TABELA}}','{{CABECALHO}}'],
            ['teste', $dataInicio->format('d-m-Y'),$dataFim->format('d-m-Y'), number_format($totalRecebido, 2, ',', '.'),$dadosTabela,$headerTable],
            $html
        );

        $dompdf = new Dompdf();
        $dompdf->loadHtml($conteudo_pdf);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="arquivo.pdf"'); // inline = exibir no navegador
        echo $dompdf->output();
    }
}
