<?php
require_once("_class/PHPWord.php");

$PHPWord = new PHPWord();

$document = $PHPWord->loadTemplate("_includes/contrato.docx");

switch( returnValue('cad_type') ){
	case '0':
		$pago = ' ';
		$gratuito = 'X';
	break;
	case '1':
		$pago = 'X';
		$gratuito = ' ';
	break;
	default:
		$pago = ' ';
		$gratuito = 'X';
	break;
}

$cidade = dibi::query("SELECT cidade FROM tt_cidade WHERE",returnValue('cidade'))->fetchSingle();

$document->setValue('CONTRATANTE', returnValue('nome'));
$document->setValue('REPRESENTANTE', returnValue('nome_responsavel',''));
$document->setValue('CPF', returnValue('cpf'));
$document->setValue('ENDERECO', returnValue('endereco'));
$document->setValue('PAGO', $pago);
$document->setValue('GRATUITO', $gratuito);
$document->setValue('CIDADE', $cidade);
$document->setValue('DATA', date("d/m/Y"));
$document->setValue('HORA', date("H:i:s"));
$document->setValue('IP', $_SERVER['REMOTE_ADDR']);

$nome = ereg_replace("[^a-zA-Z0-9_]", "", strtr(returnValue('nome'), "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_"));

$fileName = 'contratos/'.date("Y-m-d").'_'.returnValue('cpf').'_'.$nome.'.docx';

$document->save($fileName);
?>