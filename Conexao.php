<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Conexao
 *
 * @author Area central
 */
class Conexao {

  private $nome;
  private $host;
  private $usuario;
  private $senha;

  private $timeZone;
  private $conexao;
  private $query;

  function __construct($sNome = 'avaliacao', $sHost = 'localhost', $sUsuario = 'root', $sSenha = '') {
    $this->nome    = $sNome;
    $this->host    = $sHost;
    $this->usuario = $sUsuario;
    $this->senha   = $sSenha;
  }

  public function setConexao() {
    if(!empty($this->host) && !empty($this->usuario)) {
      if (@$this->conexao = mysqli_connect($this->host, $this->usuario, $this->senha)) {
        mysqli_select_db($this->conexao, $this->nome);

        mysqli_query($this->conexao, 'SET character_set_connection=utf8');
        mysqli_query($this->conexao, 'SET character_set_client=utf8');
        mysqli_query($this->conexao, 'SET character_set_results=utf8');

        $nOffset = -10800;
        $this->timeZone = sprintf('Etc/GMT+%s', ($nOffset / 3600 * -1));

        date_default_timezone_set($this->timeZone);

        $this->query(sprintf("SET time_zone = '%s'", date('P')));
        date_default_timezone_set($this->timeZone);
      } else {
        echo 'Nosso banco de dados não está respondendo à solicitação de acesso, já estamos verificando. Por favor aguarde!';
      }
    } else {
      echo 'not working';
    }
  }

  public function query($sSql, $bReturn = false) {
    if($rQry = mysqli_query($this->conexao, $sSql)) {
      if($bReturn) {
        return $rQry;
      } else {
        $this->query = $rQry;
      }
    }
  }

  public function getQuery() {
    return $this->query;
  }

  public function closeConexao() {
    mysqli_close($this->conexao);
  }

  public function getArrayResults() {
    $aReturn = [];
    while ($aDados = mysqli_fetch_array($this->query, MYSQLI_ASSOC)) {
      $aReturn[] = $aDados;
    }
    return $aReturn;
  }
}
