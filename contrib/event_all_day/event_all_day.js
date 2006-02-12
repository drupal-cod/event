if (isJsEnabled()) {
  addLoadEvent(eventAllDayAutoAttach);
}

function eventAllDayAutoAttach() {
  eventAllDayDetermine();
  document.getElementById("edit-start_minute_all_day").onclick = function() {
    if (document.getElementById("edit-start_minute_all_day").checked) {
      EventAllDayYes();
    }
    else {
      EventAllDayNo();
    }
    
  }
}

function eventAllDayDetermine() {
  if (  
    document.getElementById("edit-end_hour").value==23 &&
    document.getElementById("edit-end_minute").value==59 &&
    document.getElementById("edit-start_hour").value==0  &&
    document.getElementById("edit-start_minute").value==0) {
      EventAllDayYes();
      document.getElementById("edit-start_minute_all_day").checked = true;
  }
}

function EventAllDayYes() {
  document.getElementById("edit-end_hour").value=23;
  document.getElementById("edit-end_minute").value=59
  document.getElementById("edit-start_hour").value=0;
  document.getElementById("edit-start_minute").value=0;
  var divs = document.getElementsByTagName('div');
  for (var i = 0; div = divs[i]; i++) {
    if (div && hasClass(div, 'time')) {
      div.setAttribute('style', 'display: none;');
    }
  }
}

function EventAllDayNo() {
  var divs = document.getElementsByTagName('div');
  for (var i = 0; div = divs[i]; i++) {
    if (div && hasClass(div, 'time')) {
      div.removeAttribute('style');
    }
  }
}
