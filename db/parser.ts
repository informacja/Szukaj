// import * as fs from 'fs'

// onload = () => console.log("red");

// let document:Document = window.document;
// let body:Body = document.body;

// var el = document.getElementById('element');\
var x = document.getElementsByTagName("*");
l = x.length;
for (i = 0; i < l; i++) {
    document.write(x[i].tagName + "<br>");
}

document.write('<div style="position:absolute;right:10px;width:10vw;height:3%;opacity:0.3;z-index:100;background:#000;">TO DO:<br>Filtracja </div>' );


var bo = document.getElementsByTagName('body');

console.warn(bo);

bd.HTMLCollection[0] += '<p><a id="clickme" href="#">Click me</a></p>';
document.getElementById('clickme').onclick = function (e) {
    e.preventDefault();
    document.body.innerHTML +='<div style="position:absolute;width:100%;height:100%;opacity:0.3;z-index:100;background:#000;"></div>';
}

let DBFileName = "../db/log_request.htm";
// fs.readFileSync(DBFileName,'utf8');

const fs = require('fs');
const util = require('util');

const readFile = util.promisify(fs.readFile);
// const readdir = util.promisify(fs.readdir);

async function read1 (file) {
    const label = `read1-${file}`;
    console.time(label);
    const data = await readFile(file, 'utf8');
    const header = data.split(/\n/)[0];
    console.timeEnd(label);
}

async function read2 (file) {
    return new Promise(resolve => {
        let header;
        const label = `read2-${file}`;
        console.time(label);
        const stream = fs.createReadStream(file, {encoding: 'utf8'});
        stream.on('data', data => {
            header = data.split(/\n/)[0];
            stream.destroy();
        });
        stream.on('close', () => {
            console.timeEnd(label);
            resolve();
        });
    });
}

async function startTests(files) {
    for (let file of files) {
        console.log(file);
        await read1(file);
        await read2(file);
    }
}

// readdir(DBFileName).then(files => {
//     startTests(files.filter(file => /dummy\d+\.csv/.test(file)));
// });

