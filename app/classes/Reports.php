<?php
namespace app\classes;

use Dompdf\Dompdf;

class Reports
{
    public function __construct()
    {
    }

    private function selectHeader($type)
    {
        switch ($type) {
            case 'schedule':
                return "<tr>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Hora Início</th>
                            <th>Hora Fim</th>
                            <th>Cliente</th>
                            <th>Preço</th>
                        </tr>";
            case 'pagamentos':
                return "<tr>
                            <th>Data</th>
                            <th>Colaborador</th>
                            <th>Valor</th>
                        </tr>";
            case 'recebimentos':
                return "<tr>
                            <th>Data</th>
                            <th>Valor</th>
                        </tr>";
            default:
                return "";
        }
    }

    private function selectTitle($type, $status = '')
    {
        switch ($type) {
            case 'schedule':
                return "Relatório de Agendamentos " . $status;
            case 'pagamentos':
                return "Relatório de Pagamentos por Colaborador";
            case 'recebimentos':
                return "Relatório de Recebimentos";
            default:
                return "";
        }
    }

    private function buildTableRows($type, $dados)
    {
        $rows = '';
        foreach ($dados as $linha) {
            switch ($type) {
                case 'schedule':
                    $rows .= "<tr>
                                <td>{$linha->getDateSchedule()->format('d-m-Y')}</td>
                                <td>{$linha->getStatus()}</td>
                                <td>{$linha->getStartTime()->format('H:i')}</td>
                                <td>{$linha->getEndTime()->format('H:i')}</td>
                                <td>{$linha->getClient()->getName()}</td>
                                <td>R$ " . number_format($linha->getTotalPaid(), 2, ',', '.') . "</td>
                              </tr>";
                    break;

                case 'pagamentos':
                    $rows .= "<tr>
                                <td>{$linha->getDateReceipt()->format('d-m-Y')}</td>
                                <td>{$linha->getCollaborator()->getName()}</td>
                                <td>R$ " . number_format($linha->getAmount(), 2, ',', '.') . "</td>
                              </tr>";
                    break;

                case 'recebimentos':
                    $rows .= "<tr>
                                <td>{$linha->getDateReceipt()->format('d-m-Y')}</td>
                                <td>R$ " . number_format($linha->getAmount(), 2, ',', '.') . "</td>
                              </tr>";
                    break;
            }
        }
        return $rows;
    }

    public function generatePDF($type, $dados, $dataInicio, $dataFim)
    {
        $dataInicio = new \DateTime($dataInicio);
        $dataFim = new \DateTime($dataFim);

        $dadosTabela = $this->buildTableRows($type, $dados);

        if($type == 'pagamentos' || $type == 'recebimentos'){
            $totalRecebido = array_reduce($dados, function ($total, $linha) {
                return $total + $linha->getAmount();
            }, 0);
        }else{
            $totalRecebido = array_reduce($dados, function ($total, $linha) {
                return $total + $linha->getTotalPaid();
            }, 0);
        }
        

        $html = file_get_contents(__DIR__ .'../../views/templateRelatorio.html');
        $title = $this->selectTitle($type);
        $headerTable = $this->selectHeader($type);

        $conteudo_pdf = str_replace(
            ['{{TITLE}}', '{{DATA_INICIO}}', '{{DATA_FIM}}', '{{TOTAL_RECEBIDO}}', '{{DADOS_TABELA}}', '{{CABECALHO}}'],
            [$title, $dataInicio->format('d-m-Y'), $dataFim->format('d-m-Y'), number_format($totalRecebido, 2, ',', '.'), $dadosTabela, $headerTable],
            $html
        );

        $dompdf = new Dompdf();
        $dompdf->loadHtml($conteudo_pdf);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="relatorio.pdf"');
        echo $dompdf->output();
    }
}
