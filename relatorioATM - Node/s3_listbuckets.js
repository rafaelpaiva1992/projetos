const AWS = require('aws-sdk');
const fs = require('fs');
const path = require('path');

AWS.config.update({
    accessKeyId: "AKIAJRQSUAN4JJXRO76A",
    secretAccessKey: "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"
  },
  {region: 'sa-east-1'},
  {apiVersion: '2012-10-17'}
  );

  var s3 = new AWS.S3();
  //var filePath = "./files/975692.rar";

  fs.readdir('files', function(err, arquivos){
   
    for (var i=0; i<arquivos.length; i++) {
        //totalarquivos[y] = arquivos[i];

        var filePath = `./files/${arquivos[i]}`;

        //configuring parameters
        var params = {
        Bucket: 'testerelatm',
        Body : fs.createReadStream(filePath),
        //Key : "folder/"+Date.now()+"_"+path.basename(filePath)
        Key : path.basename(filePath)
        };

        s3.upload(params, function (err, data) {
            //handle error
            if (err) {
              console.log("Error", err);
            }
          
            //success
            if (data) {
              console.log("Sucesso Uploaded in:", data.Location);
            }
          });
    }
  });
  s3.listBuckets(function(err, data) {
    if (err) {
      console.log("Error", err);
    } else {
      console.log("Success", data.Buckets);
    }
    });
