<?php
namespace Henriqueak\LaravelBoleto\Cnab\Retorno\Cnab400\Banco;

use Henriqueak\LaravelBoleto\Cnab\Retorno\Cnab400\AbstractRetorno;
use Henriqueak\LaravelBoleto\Contracts\Boleto\Boleto as BoletoContract;
use Henriqueak\LaravelBoleto\Contracts\Cnab\RetornoCnab400;
use Henriqueak\LaravelBoleto\Util;

class Bradesco extends AbstractRetorno implements RetornoCnab400
{
    /**
     * Código do banco
     *
     * @var string
     */
    protected $codigoBanco = BoletoContract::COD_BANCO_BRADESCO;

    /**
     * Array com as ocorrencias do banco;
     *
     * @var array
     */
    private $ocorrencias = [
        "02" => "Entrada Confirmada",
        "03" => "Entrada Rejeitada",
        "06" => "Liquidação normal (sem motivo)",
        "09" => "Baixado Automat. via Arquivo",
        "10" => "Baixado conforme instruções da Agência",
        "11" => "Em Ser - Arquivo de Títulos pendentes (sem motivo)",
        "12" => "Abatimento Concedido (sem motivo)",
        "13" => "Abatimento Cancelado (sem motivo)",
        "14" => "Vencimento Alterado (sem motivo)",
        "15" => "Liquidação em Cartório (sem motivo)",
        "16" => "Título Pago em Cheque - Vinculado",
        "17" => "Liquidação após baixa ou Título não registrado (sem motivo)",
        "18" => "Acerto de Depositária (sem motivo)",
        "19" => "Confirmação Receb. Inst. de Protesto",
        "20" => "Confirmação Recebimento Instrução Sustação de Protesto (sem motivo)",
        "21" => "Acerto do Controle do Participante (sem motivo)",
        "22" => "Título Com Pagamento Cancelado",
        "23" => "Entrada do Título em Cartório (sem motivo)",
        "24" => "Entrada rejeitada por CEP Irregular",
        "27" => "Baixa Rejeitada",
        "28" => "Débito de tarifas/custas",
        "30" => "Alteração de Outros Dados Rejeitados",
        "32" => "Instrução Rejeitada",
        "33" => "Confirmação Pedido Alteração Outros Dados (sem motivo)",
        "34" => "Retirado de Cartório e Manutenção Carteira (sem motivo)",
        "35" => "Desagendamento do débito automático",
        "40" => "Estorno de pagamento (Novo)",
        "55" => "Sustado judicial (Novo)",
        "68" => "Acerto dos dados do rateio de Crédito",
        "69" => "Cancelamento dos dados do rateio",
    ];

    /**
     * Array com as possiveis rejeicoes do banco.
     *
     * @var array
     */
    private $rejeicoes = [
        '02' => 'Código do registro detalhe inválido',
        '03' => 'Código da ocorrência inválida',
        '04' => 'Código de ocorrência não permitida para a carteira',
        '05' => 'Código de ocorrência não numérico',
        '07' => 'Agência/conta/Digito - |Inválido',
        '08' => 'Nosso número inválido',
        '09' => 'Nosso número duplicado',
        '10' => 'Carteira inválida',
        '13' => 'Identificação da emissão do bloqueto inválida',
        '16' => 'Data de vencimento inválida',
        '18' => 'Vencimento fora do prazo de operação',
        '20' => 'Valor do Título inválido',
        '21' => 'Espécie do Título inválida',
        '22' => 'Espécie não permitida para a carteira',
        '24' => 'Data de emissão inválida',
        '28' => 'Código do desconto inválido',
        '38' => 'Prazo para protesto/ Negativação inválido (ALTERADO)',
        '44' => 'Agência Beneficiário não prevista',
        '45' => 'Nome do pagador não informado',
        '46' => 'Tipo/número de inscrição do pagador inválidos',
        '47' => 'Endereço do pagador não informado',
        '48' => 'CEP Inválido',
        '50' => 'CEP irregular - Banco Correspondente',
        '63' => 'Entrada para Título já cadastrado',
        '65' => 'Limite excedido',
        '66' => 'Número autorização inexistente',
        '68' => 'Débito não agendado - erro nos dados de remessa',
        '69' => 'Débito não agendado - Pagador não consta no cadastro de autorizante',
        '70' => 'Débito não agendado - Beneficiário não autorizado pelo Pagador',
        '71' => 'Débito não agendado - Beneficiário não participa do débito Automático',
        '72' => 'Débito não agendado - Código de moeda diferente de R$',
        '73' => 'Débito não agendado - Data de vencimento inválida',
        '74' => 'Débito não agendado - Conforme seu pedido, Título não registrado',
        '75' => 'Débito não agendado – Tipo de número de inscrição do debitado inválido',
    ];

    private $motivos = [
        '02' => [
            '00' => 'Ocorrência aceita',
            '01' => 'Código do Banco inválido',
            '04' => 'Código do movimento não permitido para a carteira',
            '15' => 'Características da cobrança incompatíveis',
            '17' => 'Data de vencimento anterior a data de emissão',
            '21' => 'Espécie do Título inválido',
            '24' => 'Data da emissão inválida',
            '27' => 'Valor/taxa de juros mora inválido',
            '38' => 'Prazo para protesto/ Negativação inválido (ALTERADO)',
            '39' => 'Pedido para protesto/ Negativação não permitido para o título (ALTERADO)',
            '43' => 'Prazo para baixa e devolução inválido',
            '45' => 'Nome do Pagador inválido',
            '46' => 'Tipo/num. de inscrição do Pagador inválidos',
            '47' => 'Endereço do Pagador não informado',
            '48' => 'CEP Inválido',
            '50' => 'CEP referente a Banco correspondente',
            '53' => 'Nº de inscrição do Pagador/avalista inválidos  (CPF/CNPJ)',
            '54' => 'Pagador/avalista não informado',
            '67' => 'Débito automático agendado',
            '68' => 'Débito não agendado - erro nos dados de remessa',
            '69' => 'Débito não agendado - Pagador não consta no cadastro de autorizante',
            '70' => 'Débito não agendado - Beneficiário não autorizado pelo Pagador',
            '71' => 'Débito não agendado - Beneficiário não participa da modalidade de déb.automático',
            '72' => 'Débito não agendado - Código de moeda diferente de R$',
            '73' => 'Débito não agendado -  Data de vencimento inválida/vencida',
            '75' => 'Débito não agendado - Tipo do número de inscrição do pagador debitado inválido',
            '76' => 'Pagador Eletrônico DDA - Esse motivo somente será disponibilizado no arquivo retorno para as empresas cadastradas nessa condição.',
            '86' => 'Seu número do documento inválido',
            '89' => 'Email Pagador não enviado – título com débito automático',
            '90' => 'Email pagador não enviado – título de cobrança sem registro'
        ],
        '03' => [
           '02' => 'Código do registro detalhe inválido',
           '03' => 'Código da ocorrência inválida',
           '04' => 'Código de ocorrência não permitida para a carteira',
           '05' => 'Código de ocorrência não numérico',
           '07' => 'Agência/conta/Digito - |Inválido',
           '08' => 'Nosso número inválido',
           '09' => 'Nosso número duplicado',
           '10' => 'Carteira inválida',
           '13' => 'Identificação da emissão do bloqueto inválida',
           '16' => 'Data de vencimento inválida',
           '18' => 'Vencimento fora do prazo de operação',
           '20' => 'Valor do Título inválido',
           '21' => 'Espécie do Título inválida',
           '22' => 'Espécie não permitida para a carteira',
           '24' => 'Data de emissão inválida',
           '28' => 'Código do desconto inválido',
           '38' => 'Prazo para protesto/ Negativação inválido (ALTERADO)',
           '44' => 'Agência Beneficiário não prevista',
           '45' => 'Nome do pagador não informado',
           '46' => 'Tipo/número de inscrição do pagador inválidos',
           '47' => 'Endereço do pagador não informado',
           '48' => 'CEP Inválido',
           '50' => 'CEP irregular - Banco Correspondente',
           '63' => 'Entrada para Título já cadastrado',
           '65' => 'Limite excedido',
           '66' => 'Número autorização inexistente',
           '68' => 'Débito não agendado - erro nos dados de remessa',
           '69' => 'Débito não agendado - Pagador não consta no cadastro de autorizante',
           '70' => 'Débito não agendado - Beneficiário não autorizado pelo Pagador',
           '71' => 'Débito não agendado - Beneficiário não participa do débito Automático',
           '72' => 'Débito não agendado - Código de moeda diferente de R$',
           '73' => 'Débito não agendado - Data de vencimento inválida',
           '74' => 'Débito não agendado - Conforme seu pedido, Título não registrado',
           '75' => 'Débito não agendado – Tipo de número de inscrição do debitado inválido',
        ],
        '06' => [
           '00' => 'Título pago com dinheiro',
           '15' => 'Título pago com cheque',
           '18' => 'Pagamento Parcial',
           '42' => 'Rateio não efetuado, cód. Calculo 2 (VLR. Registro) e v',
        ],
        '09' => [
            '00' => 'Ocorrência Aceita',
            '10' => 'Baixa Comandada pelo cliente',
        ],
        '10' => [
            '00' => 'Baixado Conforme Instruções da Agência',
            '14' => 'Título Protestado',
            '15' => 'Título excluído',
            '16' => 'Título Baixado pelo Banco por decurso Prazo',
            '17' => 'Titulo Baixado Transferido Carteira',
            '20' => 'Titulo Baixado e Transferido para Desconto',
        ],
        '15' => [
            '00' => 'Título pago com dinheiro',
            '15' => 'Título pago com cheque',
        ],
        '17' => [
            '00' => 'Título pago com dinheiro',
            '15' => 'Título pago com cheque',
        ],
        '24' => [
            '48' => 'CEP inválido',
        ],
        '27' => [
            '04' => 'Código de ocorrência não permitido para a carteira',
            '07' => 'Agência/Conta/dígito inválidos',
            '08' => 'Nosso número inválido',
            '10' => 'Carteira inválida',
            '15' => 'Carteira/Agência/Conta/nosso número inválidos',
            '40' => 'Título com ordem de protesto emitido',
            '42' => 'Código para baixa/devolução via Tele Bradesco inválido',
            '60' => 'Movimento para Título não cadastrado',
            '77' => 'Transferência para desconto não permitido para a carteira',
            '85' => 'Título com pagamento vinculado',
        ],
        '28' => [
           '02' => 'Tarifa de permanência título cadastrado (NOVO)',
           '03' => 'Tarifa de sustação/Excl Negativação (ALTERADO)',
           '04' => 'Tarifa de protesto/Incl Negativação (ALTERADO)',
           '05' => 'Tarifa de outras instruções (NOVO)',
           '06' => 'Tarifa de outras ocorrências (NOVO)',
           '08' => 'Custas de protesto',
           '12' => 'Tarifa de registro (NOVO)',
           '13' => 'Tarifa título pago no Bradesco (NOVO)',
           '14' => 'Tarifa título pago compensação (NOVO)',
           '15' => 'Tarifa título baixado não pago (NOVO)',
           '16' => 'Tarifa alteração de vencimento (NOVO)',
           '17' => 'Tarifa concessão abatimento (NOVO)',
           '18' => 'Tarifa cancelamento de abatimento (NOVO)',
           '19' => 'Tarifa concessão desconto (NOVO)',
           '20' => 'Tarifa cancelamento desconto (NOVO)',
           '21' => 'Tarifa título pago cics (NOVO)',
           '22' => 'Tarifa título pago Internet (NOVO)',
           '23' => 'Tarifa título pago term. gerencial serviços (NOVO)',
           '24' => 'Tarifa título pago Pág-Contas (NOVO)',
           '25' => 'Tarifa título pago Fone Fácil (NOVO)',
           '26' => 'Tarifa título Déb. Postagem (NOVO)',
           '27' => 'Tarifa impressão de títulos pendentes (NOVO)',
           '28' => 'Tarifa título pago BDN (NOVO)',
           '29' => 'Tarifa título pago Term. Multi Função (NOVO)',
           '30' => 'Impressão de títulos baixados (NOVO)',
           '31' => 'Impressão de títulos pagos (NOVO)',
           '32' => 'Tarifa título pago Pagfor (NOVO)',
           '33' => 'Tarifa reg/pgto – guichê caixa (NOVO)',
           '34' => 'Tarifa título pago retaguarda (NOVO)',
           '35' => 'Tarifa título pago Subcentro (NOVO)',
           '36' => 'Tarifa título pago Cartão de Crédito (NOVO)',
           '37' => 'Tarifa título pago Comp Eletrônica (NOVO)',
           '38' => 'Tarifa título Baix. Pg. Cartório (NOVO)',
           '39' => 'Tarifa título baixado acerto BCO (NOVO)',
           '40' => 'Baixa registro em duplicidade (NOVO)',
           '41' => 'Tarifa título baixado decurso prazo (NOVO)',
           '42' => 'Tarifa título baixado Judicialmente (NOVO)',
           '43' => 'Tarifa título baixado via remessa (NOVO)',
           '44' => 'Tarifa título baixado rastreamento (NOVO)',
           '45' => 'Tarifa título baixado conf. Pedido (NOVO)',
           '46' => 'Tarifa título baixado protestado (NOVO)',
           '47' => 'Tarifa título baixado p/ devolução (NOVO)',
           '48' => 'Tarifa título baixado franco pagto  (NOVO)',
           '49' => 'Tarifa título baixado SUST/RET/CARTÓRIO (NOVO)',
           '50' => 'Tarifa título baixado SUS/SEM/REM/CARTÓRIO (NOVO)',
           '51' => 'Tarifa título transferido desconto (NOVO)',
           '52' => 'Cobrado baixa manual (NOVO)',
           '53' => 'Baixa por acerto cliente (NOVO)',
           '54' => 'Tarifa baixa por contabilidade (NOVO)',
           '55' => 'Tr. tentativa cons deb aut',
           '56' => 'Tr. credito online',
           '57' => 'Tarifa reg/pagto Bradesco Expresso',
           '58' => 'Tarifa emissão Papeleta (NOVO)',
           '59' => 'Tarifa fornec papeleta semi preenchida (NOVO)',
           '60' => 'Acondicionador de papeletas (RPB)S (NOVO)',
           '61' => 'Acond. De papelatas (RPB)s PERSONAL (NOVO)',
           '62' => 'Papeleta formulário branco (NOVO)',
           '63' => 'Formulário A4 serrilhado (NOVO)',
           '64' => 'Fornecimento de softwares transmiss (NOVO)',
           '65' => 'Fornecimento de softwares consulta (NOVO)',
           '66' => 'Fornecimento Micro Completo (NOVO)',
           '67' => 'Fornecimento MODEN (NOVO)',
           '68' => 'Fornecimento de  máquina FAX (NOVO)',
           '69' => 'Fornecimento de máquinas óticas  (NOVO)',
           '70' => 'Fornecimento de Impressoras (NOVO)',
           '71' => 'Reativação de título (NOVO)',
           '72' => 'Alteração de produto negociado (NOVO)',
           '73' => 'Tarifa emissão de contra recibo (NOVO)',
           '74' => 'Tarifa emissão 2ª via papeleta (NOVO)',
           '75' => 'Tarifa regravação arquivo retorno (NOVO)',
           '76' => 'Arq. Títulos a vencer mensal (NOVO)',
           '77' => 'Listagem auxiliar de crédito (NOVO)',
           '78' => 'Tarifa cadastro cartela instrução permanente (NOVO)',
           '79' => 'Canalização de Crédito (NOVO)',
           '80' => 'Cadastro de Mensagem Fixa (NOVO)',
           '81' => 'Tarifa reapresentação automática título (NOVO)',
           '82' => 'Tarifa registro título déb. Automático (NOVO)',
           '83' => 'Tarifa Rateio de Crédito (NOVO)',
           '84' => 'Emissão papeleta sem valor (NOVO)',
           '85' => 'Sem uso (NOVO)',
           '86' => 'Cadastro de reembolso de diferença (NOVO)',
           '87' => 'Relatório fluxo de pagto (NOVO)',
           '88' => 'Emissão Extrato mov. Carteira (NOVO)',
           '89' => 'Mensagem campo local de pagto (NOVO)',
           '90' => 'Cadastro Concessionária serv. Publ. (NOVO)',
           '91' => 'Classif. Extrato Conta Corrente (NOVO)',
           '92' => 'Contabilidade especial (NOVO)',
           '93' => 'Realimentação pagto (NOVO)',
           '94' => 'Repasse de Créditos (NOVO)',
           '96' => 'Tarifa reg. Pagto outras mídias (NOVO)',
           '97' => 'Tarifa Reg/Pagto – Net Empresa (NOVO)',
           '98' => 'Tarifa título pago vencido (NOVO)',
           '99' => 'TR Tít. Baixado por decurso prazo (NOVO)',
           '100' => 'Arquivo Retorno Antecipado (NOVO)',
           '101' => 'Arq retorno Hora/Hora (NOVO)',
           '102' => 'TR. Agendamento Déb Aut (NOVO)',
           '105' => 'TR. Agendamento rat. Crédito (NOVO)',
           '106' => 'TR Emissão aviso rateio  (NOVO)',
           '107' => 'Extrato de protesto (NOVO)',
        ],
        '29' => [
            '78' => 'Pagador alega que faturamento e indevido',
            '95' => 'Pagador aceita/reconhece o faturamento',
        ],
        '30' => [
           '01' => 'Código do Banco inválido',
           '04' => 'Código de ocorrência não permitido para a carteira',
           '05' => 'Código da ocorrência não numérico',
           '08' => 'Nosso número inválido',
           '15' => 'Característica da cobrança incompatível',
           '16' => 'Data de vencimento inválido',
           '17' => 'Data de vencimento anterior a data de emissão',
           '18' => 'Vencimento fora do prazo de operação',
           '24' => 'Data de emissão Inválida',
           '26' => 'Código de juros de mora inválido (NOVO)',
           '27' => 'Valor/taxa de juros de mora inválido (NOVO)',
           '28' => 'Código de desconto inválido (NOVO)',
           '29' => 'Valor do desconto maior/igual ao valor do Título',
           '30' => 'Desconto a conceder não confere',
           '31' => 'Concessão de desconto já existente ( Desconto anterior )',
           '32' => 'Valor do IOF inválido',
           '33' => 'Valor do abatimento inválido',
           '34' => 'Valor do abatimento maior/igual ao valor do Título',
           '38' => 'Prazo para protesto/ Negativação inválido (ALTERADO)',
           '39' => 'Pedido para protesto/ Negativação não permitido para o título (ALTERADO)',
           '40' => 'Título com ordem/pedido de protesto/Negativação emitido (ALTERADO)',
           '42' => 'Código para baixa/devolução inválido',
           '46' => 'Tipo/número de inscrição do pagador inválidos (NOVO)',
           '48' => 'Cep Inválido (NOVO)',
           '53' => 'Tipo/Número de inscrição do pagador/avalista inválidos (NOVO)',
           '54' => 'Pagadorr/avalista não informado (NOVO)',
           '57' => 'Código da multa inválido (NOVO)',
           '58' => 'Data da multa inválida (NOVO)',
           '60' => 'Movimento para Título não cadastrado',
           '79' => 'Data de Juros de mora Inválida (NOVO)',
           '80' => 'Data do desconto inválida (NOVO)',
           '85' => 'Título com Pagamento Vinculado.',
           '88' => 'E-mail Pagador não lido no prazo 5 dias (NOVO)',
           '91' => 'E-mail pagador não recebido (NOVO)',
        ],
        '32' => [
           '01' => 'Código do Banco inválido',
           '02' => 'Código do registro detalhe inválido',
           '04' => 'Código de ocorrência não permitido para a carteira',
           '05' => 'Código de ocorrência não numérico',
           '07' => 'Agência/Conta/dígito inválidos',
           '08' => 'Nosso número inválido',
           '10' => 'Carteira inválida',
           '15' => 'Características da cobrança incompatíveis',
           '16' => 'Data de vencimento inválida',
           '17' => 'Data de vencimento anterior a data de emissão',
           '18' => 'Vencimento fora do prazo de operação',
           '20' => 'Valor do título inválido',
           '21' => 'Espécie do Título inválida',
           '22' => 'Espécie não permitida para a carteira',
           '24' => 'Data de emissão inválida',
           '28' => 'Código de desconto via Telebradesco inválido',
           '29' => 'Valor do desconto maior/igual ao valor do Título',
           '30' => 'Desconto a conceder não confere',
           '31' => 'Concessão de desconto - Já existe desconto anterior',
           '33' => 'Valor do abatimento inválido',
           '34' => 'Valor do abatimento maior/igual ao valor do Título',
           '36' => 'Concessão abatimento - Já existe abatimento anterior',
           '38' => 'Prazo para protesto/ Negativação inválido (ALTERADO)',
           '39' => 'Pedido para protesto/ Negativação não permitido para o título (ALTERADO)',
           '40' => 'Título com ordem/pedido de protesto/Negativação emitido (ALTERADO)',
           '41' => 'Pedido de sustação/excl p/ Título sem instrução de protesto/Negativação (ALTERADO)',
           '42' => 'Código para baixa/devolução inválido',
           '45' => 'Nome do Pagador não informado',
           '46' => 'Tipo/número de inscrição do Pagador inválidos',
           '47' => 'Endereço do Pagador não informado',
           '48' => 'CEP Inválido',
           '50' => 'CEP referente a um Banco correspondente',
           '53' => 'Tipo de inscrição do pagador avalista inválidos',
           '60' => 'Movimento para Título não cadastrado',
           '85' => 'Título com pagamento vinculado',
           '86' => 'Seu número inválido',
           '94' => 'Título Penhorado – Instrução Não Liberada pela Agência (NOVO)',
           '97' => 'Instrução não permitida título negativado (NOVO)',
           '98' => 'Inclusão Bloqueada face a determinação Judicial (NOVO)',
           '99' => 'Telefone beneficiário não informado / inconsistente (NOVO)',
        ],
        '35' => [
           '81' => 'Tentativas esgotadas, baixado',
           '82' => 'Tentativas esgotadas, pendente',
           '83' => 'Cancelado pelo Pagador e Mantido Pendente, conforme negociação (NOVO)',
           '84' => 'Cancelado pelo pagador e baixado, conforme negociação (NOVO)',
        ],
    ];

    /**
     * Roda antes dos metodos de processar
     */
    protected function init()
    {
        $this->totais = [
            'liquidados' => 0,
            'entradas' => 0,
            'baixados' => 0,
            'protestados' => 0,
            'erros' => 0,
            'alterados' => 0,
        ];
    }

    /**
     * @param array $header
     *
     * @return bool
     * @throws \Exception
     */
    protected function processarHeader(array $header)
    {
        $this->getHeader()
            ->setOperacaoCodigo($this->rem(2, 2, $header))
            ->setOperacao($this->rem(3, 9, $header))
            ->setServicoCodigo($this->rem(10, 11, $header))
            ->setServico($this->rem(12, 26, $header))
            ->setCodigoCliente($this->rem(27, 46, $header))
            ->setData($this->rem(95, 100, $header))
            ->setAvisoBancario($this->rem(109, 113, $header));

        return true;
    }

    /**
     * @param array $detalhe
     *
     * @return bool
     * @throws \Exception
     */
    protected function processarDetalhe(array $detalhe)
    {
        if ($this->count() == 1) {
            $this->getHeader()
                ->setAgencia($this->rem(25, 29, $detalhe))
                ->setConta($this->rem(30, 36, $detalhe))
                ->setContaDv($this->rem(37, 37, $detalhe));
        }
        $msgAdicional = str_split(sprintf('%08s', $this->rem(319, 328, $detalhe)), 2) + array_fill(0, 5, '');
        $d = $this->detalheAtual();
        $d->setCarteira($this->rem(108, 108, $detalhe))
            ->setNossoNumero($this->rem(71, 82, $detalhe))
            ->setNumeroDocumento($this->rem(117, 126, $detalhe))
            ->setNumeroControle($this->rem(38, 62, $detalhe))
            ->setOcorrencia($this->rem(109, 110, $detalhe))
            ->setOcorrenciaDescricao(array_get($this->ocorrencias, $d->getOcorrencia(), 'Desconhecida'))
            ->setDataOcorrencia($this->rem(111, 116, $detalhe))
            ->setDataVencimento($this->rem(147, 152, $detalhe))
            ->setDataCredito($this->rem(296, 301, $detalhe))
            ->setValor(Util::nFloat($this->rem(153, 165, $detalhe)/100, 2, false))
            ->setValorTarifa(Util::nFloat($this->rem(176, 188, $detalhe)/100, 2, false))
            ->setValorIOF(Util::nFloat($this->rem(215, 227, $detalhe)/100, 2, false))
            ->setValorAbatimento(Util::nFloat($this->rem(228, 240, $detalhe)/100, 2, false))
            ->setValorDesconto(Util::nFloat($this->rem(241, 253, $detalhe)/100, 2, false))
            ->setValorRecebido(Util::nFloat($this->rem(254, 266, $detalhe)/100, 2, false))
            ->setValorMora(Util::nFloat($this->rem(267, 279, $detalhe)/100, 2, false))
            ->setValorMulta(Util::nFloat($this->rem(280, 292, $detalhe)/100, 2, false))
            ->setMotivo1(array_get($this->motivos[$d->getOcorrencia()], $msgAdicional[0], null))
            ->setMotivo2(array_get($this->motivos[$d->getOcorrencia()], $msgAdicional[1], null))
            ->setMotivo3(array_get($this->motivos[$d->getOcorrencia()], $msgAdicional[2], null))
            ->setMotivo4(array_get($this->motivos[$d->getOcorrencia()], $msgAdicional[3], null))
            ->setMotivo5(array_get($this->motivos[$d->getOcorrencia()], $msgAdicional[4], null));

        if ($d->hasOcorrencia('06', '15', '17')) {
            $this->totais['liquidados']++;
            $d->setOcorrenciaTipo($d::OCORRENCIA_LIQUIDADA);
        } elseif ($d->hasOcorrencia('02')) {
            $this->totais['entradas']++;
            $d->setOcorrenciaTipo($d::OCORRENCIA_ENTRADA);
        } elseif ($d->hasOcorrencia('09', '10')) {
            $this->totais['baixados']++;
            $d->setOcorrenciaTipo($d::OCORRENCIA_BAIXADA);
        } elseif ($d->hasOcorrencia('23')) {
            $this->totais['protestados']++;
            $d->setOcorrenciaTipo($d::OCORRENCIA_PROTESTADA);
        } elseif ($d->hasOcorrencia('14')) {
            $this->totais['alterados']++;
            $d->setOcorrenciaTipo($d::OCORRENCIA_ALTERACAO);
        } elseif ($d->hasOcorrencia('03', '24', '27', '30', '32')) {
            $this->totais['erros']++;
            $error = Util::appendStrings(
                array_get($this->rejeicoes, $msgAdicional[0], ''),
                array_get($this->rejeicoes, $msgAdicional[1], ''),
                array_get($this->rejeicoes, $msgAdicional[2], ''),
                array_get($this->rejeicoes, $msgAdicional[3], ''),
                array_get($this->rejeicoes, $msgAdicional[4], '')
            );
            $d->setError($error);
        } else {
            $d->setOcorrenciaTipo($d::OCORRENCIA_OUTROS);
        }

        return true;
    }

    /**
     * @param array $trailer
     *
     * @return bool
     * @throws \Exception
     */
    protected function processarTrailer(array $trailer)
    {
        $this->getTrailer()
            ->setQuantidadeTitulos($this->rem(18, 25, $trailer))
            ->setValorTitulos(Util::nFloat($this->rem(26, 39, $trailer)/100, 2, false))
            ->setQuantidadeErros((int) $this->totais['erros'])
            ->setQuantidadeEntradas((int) $this->totais['entradas'])
            ->setQuantidadeLiquidados((int) $this->totais['liquidados'])
            ->setQuantidadeBaixados((int) $this->totais['baixados'])
            ->setQuantidadeAlterados((int) $this->totais['alterados']);

        return true;
    }
}
