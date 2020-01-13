const Excel = require("./excel.js");
const moment = require('moment');
const mysql = require('mysql');
const mkdirp = require('mkdirp');
const zipFolder = require('zip-folder');
const AWS = require('aws-sdk');
const fs = require('fs');
const path = require('path');


module.exports = class Rel016 {
    constructor() {
        this._connection = mysql.createConnection({
            //host     : '192.168.50.80',
            host: '200.198.178.187',
            port: 3306,
            user: 'emergencia',
            password: '46ffd5f7',
            database: 'atm'
        });
        this._old = mysql.createConnection({
            host: '200.219.254.67',
            port: 3306,
            user: 'Hudson',
            password: '6qlgosoi',
            database: 'atm'
        });
        this._process = [];
        this._contador = 0;


        this._param = {
            columns: [
                { key: 'av_terminal', width: 15, label: 'Caixa Postal' },
                { key: 'av_serie', width: 10, label: 'Série' },
                { key: 'av_numero', width: 10, label: 'Número' },
                { key: 'av_filial', width: 10, label: 'Filial' },
                { key: 'av_tipo_docto', width: 18, label: 'Tipo Documento' },
                { key: 'av_tipo_transp', width: 18, label: 'Tipo Transporte' },
                { key: 'av_ramo', width: 10, label: 'Ramo' },
                { key: 'av_origem', width: 10, label: 'Origem' },
                { key: 'av_destino', width: 10, label: 'Destino' },
                //{ key: 'av_pais', width: 18, label: 'País' },
                { key: 'av_tipo_merc', width: 15, label: 'Tipo Mercadoria' },
                { key: 'av_val_avarias', width: 10, label: 'Avarias' },
                { key: 'av_valor_container', width: 10, label: 'Container' },
                { key: 'av_valor_acessorios', width: 10, label: 'Acessórios' },
                { key: 'av_val_impostos', width: 10, label: 'Impostos' },
                { key: 'av_val_luc_esperados', width: 18, label: 'Lucros Esperados' },
                { key: 'av_val_frete', width: 10, label: 'Frete' },
                { key: 'av_val_despesas', width: 18, label: 'Despesas' },
                { key: 'av_ddr_valor_alterado', width: 18, label: 'Valor Original' },
                { key: 'av_placa_veic', width: 10, label: 'Placa' },
                { key: 'av_data_emiss', width: 12, label: 'Emissão' },
                { key: 'av_data_inc', width: 25, label: 'Chancela' },
                { key: 'av_dt_embarque', width: 12, label: 'Embarque' },
                { key: 'av_urbano', width: 10, label: 'Urbano' },
                { key: 'av_transp_prop', width: 16, label: 'Transp. Próp.' },
                { key: 'av_rg', width: 18, label: 'RG Motorista' },
                { key: 'av_cpf', width: 18, label: 'CPF Motorista' },
                { key: 'av_ddr_cnpjcpf', width: 22, label: 'CNPJ DDR' },
                { key: 'av_ddr_tp', width: 14, label: 'Tipo DDR' },
                { key: 'tomador', width: 22, label: 'CNPJ Tomador' },
                { key: 'av_cte_cpfcgc_remetente', width: 22, label: 'CNPJ Remetente' },
                { key: 'av_cod_dan', width: 16, label: 'DACTE/DANFE' },
                { key: 'av_tipo_viagem', width: 10, label: ' IMP/EXP' },
                { key: 'av_dt_reg_can_dan', width: 22, label: 'Canc. ATM' },
                { key: 'av_dt_doc_can_dan', width: 22, label: 'Canc. SEFAZ' },
                { key: 'av_tipo_mov', width: 22, label: 'Tipo Movimento' },
                { key: 'av_obs', width: 40, label: 'OBS' },
                { key: 'v_tipo_transp_compl', width: 22, label: 'Percurso Complementar' },
                { key: 'av_origem_compl', width: 25, label: 'Origem Transp. Compl.' },
                { key: 'av_dest_compl', width: 25, label: 'Destino Transp. Compl.' },
                { key: 'av_tipo_transp_compl', width: 25, label: 'Tipo Transp. Compl.' },
                { key: 'av_cod_libera', width: 25, label: 'Cód. Liberação do Mot.' },
                { key: 'av_tx_ocd', width: 18, label: 'TX Carga Descarga' },
                { key: 'av_tx_ic', width: 11, label: 'TX Içamento' },
                { key: 'av_tx_ri', width: 15, label: 'TX Remoção Int' },
                { key: 'av_tx_rcfdc', width: 12, label: 'TX RCFDC' },
                { key: 'av_rastreado', width: 11, label: 'Rastreado' },
                { key: 'av_escolta', width: 10, label: 'Escolta' },
                { key: 'av_veic_mp', width: 16, label: 'Veículo MP' },
                { key: 'av_merc_nova', width: 18, label: 'Mercadoria Nova' },
                { key: 'av_cep_origem', width: 13, label: 'CEP Origem' },
                { key: 'av_cep_destino', width: 13, label: 'CEP Destino' },
                { key: 'av_municipio_origem', width: 16, label: 'Mun Origem' },
                //{ key: '', width: 16, label: 'Mun Origem Desc' },
                { key: 'av_municipio_destino', width: 16, label: 'Mun Destino' },
                //{ key: '', width: 16, label: 'Mun Destino Desc' },
                { key: 'av_cte_cpfcgc_expedidor', width: 22, label: 'CNPJ CTE Expedidor' },
                { key: 'av_cte_cpfcgc_recebedor', width: 22, label: 'CNPJ CTE Recebedor' },
                { key: 'av_cte_cpfcgc_destino', width: 22, label: 'CNPJ CTE Destino' },
                { key: 'av_cpfcgc_emissor', width: 22, label: 'CNPJ CTE Emissor' },
                { key: 'av_data_prot_sefaz', width: 18, label: 'DT PROT SEFAZ' },
                { key: 'av_hora_prot_sefaz', width: 18, label: 'HR PROT SEFAZ' },
                { key: 'av_status_can_dan', width: 25, label: 'Status Can.' },
                { key: 'av_hora_embarque', width: 20, label: 'Hora de Embarque' },
                { key: 'av_protocolo', width: 36, label: 'Protocolo de Averbação' },
                { key: 'av_valor', width: 22, label: 'Valor' },
                { key: 'av_numero_averbacao', width: 36, label: 'Número de Averbação' },
                { key: 'av_can_dan', width: 36, label: 'Protocolo de Cancelamento SEFAZ' },
                { key: 'av_nfe_inbound', width: 10, label: 'Inbound' },
                { key: 'av_cod_libera_limite', width: 22, label: 'Código de liberação de limite' },
                { key: 'av_cpfcgc', width: 22, label: 'CNPJ Segurado' },
                { key: 'av_nome_balsa', width: 10, label: 'Balsa 1' },
                { key: 'av_nome_balsa2', width: 10, label: 'Balsa 2' },
                { key: 'av_nome_balsa3', width: 10, label: 'Balsa 3' },
                { key: 'av_nome_navio', width: 10, label: 'Navio' },
                { key: 'av_nfe_mod_frete', width: 10, label: 'ModFrete' }
            ],
            logo: 'assets/logo.png'
        };
    }
    // aqui pega o id como referencia para nome da pasta
    build(val) {
        this._id = val.rs_id;
        setTimeout(() => {
            this._create(val)
        }, 1500);
    }

    _create(val) {
        let data = val.rs_filtro_data.split('/');
         let start = moment(`${data[1]}-${data[0]}-01`).format("YYYY-MM-DD");
        let end = moment(start).endOf('month').format("YYYY-MM-DD");
        if (new Date(`${data[1]}-${data[0]}-01`) >= new Date('2019-09-01')) {
            console.log("gerando Rel ", val.rs_id);
            this.geraRelatorio(val, start, end, this._connection, 'relations');
        } else {
            console.log("OLD");
            this._syncDatabase(val, start, end);
        }
    }

    _syncDatabase(val, start, end) {
        console.log("SyncDatabase");
        let global = this;
        let sql = `select * from relations where re_terminal_ref = '${val.rs_terminal}' and re_dt_validade_inicial <= '${end}' and re_dt_validade >= '${start}'`;
        this._connection.query(sql, function (error, result) {
            if (error) throw error;
            if (result.length > 0) {
                global._createTempRelations(result, val, start, end);
            } else {
                console.log("Sem Relations");
            }

        })
    }
    _createTempRelations(data, val, start, end) {
        console.log("Create TEMP");
        let cnn = this._old;
        let global = this;
        let sql = "CREATE temporary TABLE relations_tmp ( ";
        sql += "   re_terminal_ref varchar(8) NOT NULL, ";
        sql += "   re_terminal2 varchar(8) NOT NULL, ";
        sql += "   re_dt_validade datetime NOT NULL, ";
        sql += "   re_dt_validade_inicial datetime(6) NOT NULL ";
        sql += " ) ";
        console.log(sql);
        cnn.query(sql, async function (error) {
            if (error) throw error;
            let ins = 'insert into relations_tmp (re_terminal_ref,re_terminal2,re_dt_validade,re_dt_validade_inicial) values ';
            await data.forEach(async function (value) {
                ins += `('${value.re_terminal_ref}',`;
                ins += `'${value.re_terminal2}',`;
                ins += `'${moment(value.re_dt_validade).format("YYYY-MM-DD")}',`;
                ins += `'${moment(value.re_dt_validade_inicial).format("YYYY-MM-DD")}'),`;
            });
            console.log(ins);
            cnn.query(ins.substr(0, ins.length - 1), function (error) {
                if (error) throw error;
                if (val.rs_filtro_segurado.indexOf(';') > 0) {
                    global.geraRelatorio(val, start, end, cnn, 'relations_tmp');
                } else {
                    global.createTempGroupId(val, start, end, cnn, 'relations_tmp');
                }

            });

        })
    }
    createTempGroupId(val, start, end, tblRelations) {
        // TODO: Criar tabela gropoIntem_tmp
        this.geraRelatorio(val, start, end, old(), tblRelations);
    }
    makeSql(val, start, end, tblRelations) {
        let sql = "select ";
        sql += "   av_cpfcgc ";
        sql += " , av_cnpj_cli ";
        sql += " , av_cpfcgc_emissor ";
        sql += " , av_filial ";
        sql += " , CASE av_tipo_docto WHEN '1' THEN 'Manifesto' WHEN '2' THEN 'Conhecimento' WHEN '3' THEN 'Nota Fiscal' WHEN '4' THEN 'Ordem de Carga'  WHEN '5' THEN 'Outros' WHEN '6' THEN 'Teste' WHEN '7' THEN 'Provisoria' END AS av_tipo_docto ";
        sql += " , CASE av_tipo_transp WHEN '1' THEN 'Rodoviario' WHEN '2' THEN 'Mariticmo' WHEN '3' THEN 'Fluvial' WHEN '4' THEN 'Ferroviario' WHEN '5' THEN 'Aereo' END AS av_tipo_transp";
        sql += " , av_serie ";
        sql += " , av_numero ";
        sql += " , av_ramo ";
        sql += " , av_terminal ";
        sql += " , av_dt_reg_can_dan ";
        sql += " , date_format(av_data_emiss,'%d/%m/%Y' ) AS av_data_emiss ";
        sql += " , date_format(av_dt_embarque,'%d/%m/%Y' ) AS av_dt_embarque ";
        sql += " , av_hora_embarque ";
        sql += " , date_format(av_data_inc, '%d/%m/%Y %H:%i:%s') AS av_data_inc  ";
        sql += " , av_origem ";
        sql += " , av_destino ";
        sql += " , av_dest_compl ";
        sql += " , av_urbano ";
        sql += " , av_transp_prop ";
        sql += " , CASE WHEN av_tipo_transp_compl != '' and av_tipo_transp_compl != 0 then 'S' else 'N' end as av_tipo_transp_compl"
        sql += " , av_origem_compl ";
        sql += " , av_ddr_cnpjcpf ";
        sql += " , av_tx_rcfdc ";
        sql += " , av_can_dan ";
        sql += " ,case  ";
        sql += "	when av_cte_cpfcgc_toma4 != '' then av_cte_cpfcgc_toma4";
        sql += "	when av_cte_toma3 = '1' then av_cte_cpfcgc_expedidor";
        sql += "	when av_cte_toma3 = '2' then av_cte_cpfcgc_recebedor";
        sql += "	when av_cte_toma3 = '3' then av_cte_cpfcgc_destino";
        sql += "	else av_cte_cpfcgc_remetente end as tomador";
        sql += " , av_protocolo ";
        sql += " , av_cte_toma3";
        sql += " , av_cte_cpfcgc_expedidor";
        sql += " , av_cte_cpfcgc_recebedor";
        sql += " , av_cte_cpfcgc_destino";
        sql += " , av_cte_cpfcgc_remetente";
        sql += " , av_cte_cpfcgc_toma4";
        sql += " , coalesce((av_ddr_valor_alterado / 100),0) as av_ddr_valor_alterado";
        sql += " , case when av_dt_reg_can_dan is not null or av_tipo_mov = 2 then 0.00 else coalesce((av_valor / 100),0) end as av_valor";
        sql += " , coalesce((av_val_frete / 100),0) as av_val_frete ";
        sql += " , coalesce((av_val_despesas / 100),0) as av_val_despesas ";
        sql += " , coalesce((av_val_luc_esperados / 100),0) as av_val_luc_esperados ";
        sql += " , coalesce((av_valor_container / 100),0) as av_valor_container ";
        sql += " , coalesce((av_valor_acessorios / 100),0) as av_valor_acessorios ";
        sql += " , coalesce((av_val_impostos / 100),0) as av_val_impostos ";
        sql += " , coalesce((av_val_avarias / 100),0) as av_val_avarias ";
        sql += " , (";
        sql += "     coalesce((av_valor / 100),0) + ";
        sql += "     coalesce((av_val_frete / 100),0) + ";
        sql += "     coalesce((av_val_despesas / 100),0)+ ";
        sql += "     coalesce((av_val_luc_esperados / 100),0) + ";
        sql += "     coalesce((av_valor_container / 100),0) + ";
        sql += "     coalesce((av_valor_acessorios / 100),0) + ";
        sql += "     coalesce((av_val_impostos / 100),0) + ";
        sql += "     coalesce(((av_val_avarias) / 100),0) ";
        sql += "   ) as av_total ";
        sql += " , 1 as av_qt ";
        sql += " , av_placa_veic ";
        sql += " , CASE  av_tipo_merc WHEN '1' THEN 'Geral' END AS av_tipo_merc";
        sql += " , CASE av_tipo_mov  WHEN '1' THEN 'Normal' WHEN '2' THEN 'Cancelado' WHEN '3' THEN 'Cortesia' WHEN '4' THEN 'Resp. de Terceiros' END AS av_tipo_mov ";
        sql += " , av_cpf ";
        sql += " , av_rg ";
        sql += " , av_cod_libera ";
        sql += " , av_cod_libera_limite ";
        sql += " , av_tx_ocd ";
        sql += " , av_tx_ic ";
        sql += " , av_tx_ri ";
        sql += " , av_rastreado ";
        sql += " , av_escolta ";
        sql += " , av_veic_mp ";
        sql += " , av_obs ";
        sql += " , av_merc_nova ";
        sql += " , CASE av_tipo_viagem  WHEN '1' THEN 'Importação' WHEN '1' THEN 'Exportação' END AS av_tipo_viagem";
        sql += " , av_can_dan ";
        sql += " , av_nfe_inbound ";
        sql += " from averbacao";
        sql += ` inner join ${tblRelations} on re_terminal2 = av_terminal`;
        sql += ' where ';
        sql += ` re_terminal_ref = '${val.rs_terminal}'`;
        sql += " and av_serie <> 'SRISC'";
        sql += " and av_tipo_docto <> '6'";

        if (val.rs_filtro_segurado.indexOf(';') > 0) {
            let tmp = val.rs_filtro_segurado.split(';');
            sql += ` and av_cpfcgc = '${tmp[1]}'`;
            if (tmp[0].substr(0, 1) == 'P') {
                sql += ` and av_terminal = '${tmp[0].substr(1)}'`;
                sql += " and exists( select 1 from terminal";
                sql += "     inner join clientes on te_cod_cli = cl_cod_cli";
                sql += "     where te_terminal = av_terminal  and cl_cpfcgc = av_cpfcgc";
                sql += "     union all";
                sql += "     select 1 from clientes_emp";
                sql += "     where em_terminal = av_terminal  and em_cpfcgc = av_cpfcgc";
                sql += " )";
            } else {
                sql += ` and av_terminal = '${tmp[0]}'`;
            }

        } else {
            //TODO: WHERE GROUP
        }
        if (val.rs_filtro_tp_data == 'EMB') {
            sql += " and av_dt_embarque ";
        } else if (val.rs_filtro_tp_data == 'EMI') {
            sql += " and av_data_emiss ";
        } else if (val.rs_filtro_tp_data == 'INC') {
            sql += " and av_data_inc ";
        }
        sql += ` between '${start}' and '${end}' `;
        sql += " order by";
        sql += "   av_cpfcgc";
        sql += " , av_filial";
        sql += " , av_serie";
        sql += " , av_numero";
        sql += " , av_tipo_docto";

        return sql;
    }
    // aqui gera os relatorios e com o nome do id
    geraRelatorio(val, start, end, conn, tblRelations) {
        let global = this;
        let sql = this.makeSql(val, start, end, tblRelations);

        conn.query(sql, function (error, result, fields) {
            if (error) throw error;
            console.log(val.rs_id + " :>>>>> " + result.length);
            if (result.length > 0) {
                let data = [];
                mkdirp(`files/${val.rs_id}`, function (err) {
                    if (err) console.error(err)
                    else console.log('pow!')

                   
                });
                for (let i = 0; i <= result.length; i++) {
                    data.push(result[i]);
                    if (i > 0 && i % 200000 == 0) {

                        let file = `files/${val.rs_id}/REL_${(global._contador + 1)}_${val.rs_id}.xlsx`;
                        global._process[global._contador] = new Excel(data, global._param, file);
                        global._process[global._contador].build();
                        global._contador++;
                        data = [];
                    }
                }

                if (data.length > 0) {
                    let file = `files/${val.rs_id}/REL_${(global._contador + 1)}_${val.rs_id}.xlsx`;
                    global._process[global._contador] = new Excel(data, global._param, file);
                    global._process[global._contador].setUser(val.rs_usuario);
                    global._process[global._contador].build();
                    global._contador++;
                    data = [];
                }
            } else {

                /////////////////////////// Update na tabela não achou registro/////////////////////////
                // var sql = `update rel_solicita set rs_status = 'V', rs_arquivo= 'Sem Registro' where rs_id = ${val.rs_id}`;

                // this._connection.query(sql, function (error, result) {

                //     if (error) throw error;
                //     if (result.length > 0) {
                //         result.forEach(function (val) {
                //             rel.build(val);
                //         });
                //     } else {

                //         console.log('Update com sucesso sem registro');

                //     }
                // });

                console.log(" nenhum averbação localizado");
            }

        });

        
                // var global = this;
                // var arquivo = `${global._id}.zip`;
       
                // zipFolder(`files/${global._id}`, `files/${arquivo}`, function (err) {
       
                //     if (err) {
                //         console.log('oh no!', err);
                //     } else {
                //         console.log('deu certo');
                //     }
                // });

    }
        
 
    
}


