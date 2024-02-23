let linkPage = 'https://nistp.ru/bankrot/trade_view.php?trade_nid=' + document.URL.match(/id_lot=(.*?)&/i)[1]; //ссылка на страницу

let informationPropertyRes; // Cведения об имуществе
let initialPrice; // Начальная цена
let eMail; // E-mail
let phone; // Телефон
let inn; // ИНН
let numberBankruptcyCase; // Номер дела о банкротстве
let tradingDate; // Дата торгов

let numberLot = document.URL.slice(document.URL.lastIndexOf('=') + 1);
let tableHeader = document.querySelectorAll('.table_header');
tableHeader.forEach((item) => {
  if(item.outerText == `Лот № ${numberLot}`) {
    let parent = item.closest('.node_view');
    let informationProperty = parent.querySelectorAll('.label');
    informationProperty.forEach((i) => {
      switch (i.outerText) {
        case 'Cведения об имуществе (предприятии) должника, выставляемом на торги, его составе, характеристиках, описание':
          informationPropertyRes = i.nextElementSibling.outerText;
        case 'Начальная цена':
          initialPrice = i.nextElementSibling.outerText;
      }
    })
  }
})

let th = document.querySelectorAll('th');
th.forEach((el) => {
  if(el.outerText == 'Контактное лицо организатора торгов') {
    let pick = el.parentElement.parentElement.querySelectorAll('td');
    pick.forEach((elem) => {
      if(elem.outerText == 'E-mail') {
        eMail = elem.nextElementSibling.outerText;
      }
      if(elem.outerText == 'Телефон') {
        phone = elem.nextElementSibling.outerText;
      }
    })
  }
  if(el.outerText == 'Информация об организаторе') {
    let pick = el.closest('.node_view').querySelectorAll('td');
    pick.forEach((elem) => {
      switch (elem.outerText) {
        case 'ИНН':
          inn = elem.nextElementSibling.outerText;
      }
    })
  }
  if(el.outerText == 'Информация о должнике') {
    let pick = el.closest('.node_view').querySelectorAll('td');
    pick.forEach((elem) => {
      switch (elem.outerText) {
        case 'Номер дела о банкротстве':
          numberBankruptcyCase = elem.nextElementSibling.outerText;
      }
    })
  }

  let tradingStartDate;
  let tradingEndDate;
  if(el.outerText == 'Информация о ходе торгов') {
    let pick = el.closest('.node_view').querySelectorAll('td');
    pick.forEach((elem) => {
      switch (elem.outerText) {
        case 'Дата начала представления заявок на участие':
          tradingStartDate = elem.nextElementSibling.outerText;
        case 'Дата окончания представления заявок на участие':
          tradingEndDate = elem.nextElementSibling.outerText;
      }
      tradingDate = tradingStartDate + ' / ' + tradingEndDate;
    })
  }
})

let metaCsrf = document.createElement("meta");
metaCsrf.setAttribute("name", "csrf-token");
metaCsrf.setAttribute("content", "{{ csrf_token() }}");
document.querySelector("head").prepend(metaCsrf);

let input = document.createElement("form");
input.setAttribute("action", "../php/info_lot.php");
input.setAttribute("class", "formInfo");
input.setAttribute("method", "post");
input.setAttribute("accept-charset", "utf-8");
document.querySelector(".popup_container").after(input);

let formInfo = document.querySelector('.formInfo');
formInfo.insertAdjacentHTML('beforeend', `
  <input type="hidden" type="text" name="linkPage" value="${linkPage}">
  <input type="hidden" type="text" name="informationPropertyRes" value="${informationPropertyRes}">
  <input type="hidden" type="text" name="initialPrice" value="${initialPrice}">
  <input type="hidden" type="text" name="eMail" value="${eMail}">
  <input type="hidden" type="text" name="phone" value="${phone}">
  <input type="hidden" type="text" name="inn" value="${inn}">
  <input type="hidden" type="text" name="numberBankruptcyCase" value="${numberBankruptcyCase}">
  <input type="hidden" type="text" name="tradingDate" value="${tradingDate}">
  <input type="submit" class="info-submit">
`);
document.querySelector('.info-submit').click();