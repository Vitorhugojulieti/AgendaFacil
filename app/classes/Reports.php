<?php

use Nesk\Puphpeteer\Puppeteer;

class RelatorioAgendamentos
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function gerarRelatorio($dataInicio, $dataFim)
    {
        $sql = "SELECT a.id, a.data_agendamento, a.horario_inicio, a.horario_fim, c.nome AS cliente, s.nome AS servico, s.preco, col.nome AS colaborador
                FROM agendamentos AS a
                INNER JOIN clientes AS c ON a.cliente_id = c.id
                INNER JOIN servicos AS s ON a.servico_id = s.id
                INNER JOIN colaboradores AS col ON a.colaborador_id = col.id
                WHERE a.data_agendamento BETWEEN :dataInicio AND :dataFim
                ORDER BY a.data_agendamento, a.horario_inicio";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':dataInicio', $dataInicio);
        $stmt->bindParam(':dataFim', $dataFim);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function gerarPDF($dados, $dataInicio, $dataFim)
    {
        // Carregar o template HTML
        $html = file_get_contents("templateRelatorio.html");

        // Substituir os placeholders
        $html = str_replace("{{LOGO_PATH}}", "logo.png", $html);
        $html = str_replace("{{DATA_INICIO}}", $dataInicio, $html);
        $html = str_replace("{{DATA_FIM}}", $dataFim, $html);

        $totalRecebido = 0;
        $dadosTabela = '';

        foreach ($dados as $linha) {
            $dadosTabela .= "
            <tr>
                <td>{$linha['id']}</td>
                <td>{$linha['data_agendamento']}</td>
                <td>{$linha['horario_inicio']}</td>
                <td>{$linha['horario_fim']}</td>
                <td>{$linha['cliente']}</td>
                <td>{$linha['servico']}</td>
                <td>R$ " . number_format($linha['preco'], 2, ',', '.') . "</td>
            </tr>";
            $totalRecebido += $linha['preco'];
        }

        $html = str_replace("{{DADOS_TABELA}}", $dadosTabela, $html);
        $html = str_replace("{{TOTAL_RECEBIDO}}", "R$ " . number_format($totalRecebido, 2, ',', '.'), $html);

        // Inicializa o Puppeteer
        $puppeteer = new Puppeteer();
        $browser = $puppeteer->launch();

        // Gera o PDF
        $page = $browser->newPage();
        $page->setContent($html);
        $pdf = $page->pdf([
            'format' => 'A4',
            'printBackground' => true,
        ]);

        // Salva o PDF em um arquivo
        file_put_contents("Relatorio_Agendamentos_{$dataInicio}_{$dataFim}.pdf", $pdf);

        $browser->close();
    }
}
