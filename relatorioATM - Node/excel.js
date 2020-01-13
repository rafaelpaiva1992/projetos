const Exceljs = require('exceljs/lib/exceljs.nodejs');
const fs = require('fs');
const moment = require('moment');

module.exports = class Excel{
    constructor(dados,schema,name){
        this._dados = dados;
        this._schema = schema;
        this._name = name;
        this._running = true;
    }
    setData(dados){
        this._dados = dados;
    }
    setSchema(schema){
        this._schema = schema;
    }
    setName(name){
        this._name = name;
    }
    setUser(user){
        this._user = user;
        console.log("USUARIO:::: ",this._user);
    }
    setFilter(filter){
        this._filter = filter
    }
    isRunning(){
        return this._running;
    }
    getFileName(){
        return this._name;
    }
    _createColumns(){
        this._worksheet.columns = this._createColumnsIds();
    }
    _style(){
        this._worksheet.getRow(6).font = {
            name: 'Calibri',
            size: 11,
            bold: true
        };
        this._worksheet.getRow(2).font = {
            name: 'Calibri',
            size: 11,
            bold: true
        };
    }
    _autoFilter(){
        this._worksheet.autoFilter = {
            from: 'A6',
            to: 'BT6',
          }
    }
    _createHeader(){
        let imageId2 = this._workbook.addImage({
            buffer: fs.readFileSync(this._schema.logo),
            extension: 'png',
        });
        this._worksheet.addImage(imageId2, 'A1:B4');
        this._createTitle();
    }
    _createColumnsIds(){
        let ret = [];
        this._schema.columns.forEach(async function(val){
            ret.push({key: val.key,width: val.width});
        });
        return ret;
    }
    _createTitle() {
        let info = '{';
        this._schema.columns.forEach(async function(val) {
            info = info + '"' + val.key + '":"' + val.label + '",';
        });
        info = info.substr(0, info.length - 1) + "}";
        let jsonObj = JSON.parse(info);
        this._worksheet.addRow(jsonObj);
    }
    _setInfos(){
        this._worksheet.columns = this._createColumnsIds();
        this._worksheet.addRow();
        let rowValues = [];
        if(this._filter == 'EMB'){
            rowValues[4] = 'Relatório Padrão Post*PC por data de embarque';
        }
        if(this._filter == 'EMI'){
            rowValues[4] = 'Relatório Padrão Post*PC por data de emissão';
        }
        if(this._filter == 'INC'){
            rowValues[4] = 'Relatório Padrão Post*PC por data de inclsão';
        }
        this._worksheet.addRow(rowValues);
        this._worksheet.mergeCells('D2:H2');
        rowValues = [];
        rowValues[4] = `Solicitado por ${this._user} em ${moment().format("DD/MM/YYYY HH:mm")}`;
        this._worksheet.addRow(rowValues);
        this._worksheet.mergeCells('D3:H3');
        this._worksheet.addRow();
        this._worksheet.addRow();
        this._createHeader();
        this._style();
        this._autoFilter();
        this._setData();
                
        let options = {
            dateFormats: ['DD/MM/YYYY','DD/MM/YYYY HH:mm:ss']
        };
        this._workbook.xlsx.writeFile(this._name,options)
            .then(this.endProcess());
    }
    endProcess(){
        this._running = false;
    }
    _setData(){
        let data = this._dados;
        for (let i = 0; i < this._dados.length-1; i++) {
            let info = '{';
            for (let j in data[i]) {
                if(data[i][j] == 'null' || data[i][j] == null){
                    data[i][j] = '';
                }
                info = info + '"' + j + '":"' + data[i][j] + '",';
            }
            info = info.substr(0, info.length - 1) + "}";
            let jsonObj = JSON.parse(info);
            this._worksheet.addRow(jsonObj);
        }
    }
    _createWorkBook(){
        this._workbook = new Exceljs.Workbook();
        this._workbook.creator = 'AT&M Alta Tecnologia e Metodos';
        this._workbook.lastModifiedBy = 'AT&M Alta Tecnologia e Metodos';
        this._workbook.created = new Date();
        this._workbook.modified = new Date();
        this._workbook.lastPrinted = new Date();
        this._worksheet = this._workbook.addWorksheet('Relatório');
        this._setInfos();
    }
    build() {
        setTimeout(() => {
            this._createWorkBook()
        },1500);
    }
}
