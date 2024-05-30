function validateData(name,number,date){
  const pattern = /^[а-яёА-ЯЁ]+$/;
  if (pattern.test(name) == false){
    return ["Похоже вы ввели неверное имя. Имя должно быть на русском и не содержит цифр и символов",0];
  }
  if(number.length != 11){
    return ['Похоже вы неверно ввели номер, убедитесь что вы ввели полный номер',0];
  }
  arrDate = date.split('-');
  if(arrDate[0] >= 2007){
    return ['Похоже вы слишком малы для отправки данной формы',0];
  }
  return ["Данные сохранены успешно. Спасибо!",1]
}

function makeLengsArr(bodyObject){
  let lengs = [];
  for(let i = 0; i != 11; i++){
    if(bodyObject[`lengs[${i}]`] != undefined){
      lengs.push(bodyObject[`lengs[${i}]`]);
    }else{
      break;
    }
  };
  return lengs;
}

function InsertLengs(lengs){
  let lengsObj = {
    Pascal:0,
    C:0,
    'C++':0,
    JavaScript:0,
    Python:0,
    Java:0,
    Haskel:0,
    Clijure:0,
    Prolog:0,
    Scara:0
  }
  lengs.forEach(elem=>lengsObj[elem] = 1);
  return lengsObj;
};

function HTMLAnswer(massage){
      return (`
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Ответ формы</title>
            <link rel="stylesheet" href="http://u67380.kubsu-dev.ru/Web3/style/answer.css">
        </head>
        <div class="answer">
          <p>${massage}</p>
          <a href="javascript:history.back()"> <button class="button">Вернутся</button> <a>
        </div>`
      )
}

function HTMLTables(results){
  
  return (`
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Ответ формы</title>
            <link rel="stylesheet" href="http://u67375.kubsu-dev.ru/Web4/style/tables.css">
        </head>
        <div class="answer">
            ${results.map(colum=>{
              let html =
              `<div class="table">
              <p>Имя: ${colum.name}</p>
              <p>Номер: ${colum.number}</p>
              <p>Почта: ${colum.email}</p>
              <p>Дата: ${colum.date}</p>
              <p>Пол: ${colum.gen}</p>
              <p>О себе: ${colum.about}</p>
              <p>Языки: Pascal:${colum.pascal},C:${colum.c},C++:${colum.cpp},
              JavaScript:${colum.js},Python:${colum.py},Java:${colum.java},
              haskel:${colum.haskel},clijure:${colum.clijure},Prolog:${colum.prolog},Scara:${colum.scara}</p>
              </div>`
              return html;
            })}
          <a href="javascript:history.back()"> <button class="button">Вернутся</button> <a>
        </div>`
      )
}

module.exports = {
  validateData: validateData,
  InsertLengs: InsertLengs,
  HTMLAnswer:HTMLAnswer,
  HTMLTables:HTMLTables,
  makeLengsArr:makeLengsArr,
};