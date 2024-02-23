let pickIdValue = function pickId() {
  let data = document.querySelector('.data');
  let tbody = data.querySelector('tbody');
  let pickNumberLot = null;
  if(tbody.outerText == 'Не найдено торгов по заданным условиям') {
    window.location.href = '../../index.php?+visible_modal ';
  } else {
    let tbodyLink = tbody.querySelector('a');
    let pickStr = tbodyLink.href.slice(tbodyLink.href.lastIndexOf('=') + 1);
    let lot = tbody.querySelectorAll('span');
    lot.forEach((i, idx) => {
      if(idx == lot.length-1) {
        let pickStr = i.outerText.substring(0, i.outerText.length - 2);
        pickNumberLot = pickStr.slice(pickStr.lastIndexOf('№ ') + 1);
      }
    })
    window.location.href = `../php/showTotalPage.php?id_lot=${pickStr}&numberLot=${+pickNumberLot}`;
  }
}
pickIdValue();