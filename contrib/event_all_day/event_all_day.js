if (Drupal.jsEnabled) {
  $(document).ready(eventAllDayAutoAttach);
}

function eventAllDayToggle () {
  if ($("#edit-start-minute-all-day").attr("checked")) {
    EventAllDayYes();
  }
  else {
    EventAllDayNo();
  }
}

function eventAllDayAutoAttach() {
  eventAllDayDetermine();
  $("#edit-start-minute-all-day").attr("onClick", "eventAllDayToggle();");
}

function eventAllDayDetermine() {
  if (  
    ($("#edit-end-hour").val() == "23") &&
    ($("#edit-end-minute").val() == "59") &&
    ($("#edit-start-hour").val() == "0") &&
    ($("#edit-start-minute").val() == "0")) {
      EventAllDayYes();
      $("#edit-start-minute-all-day").attr("checked","true");
  }
}

function EventAllDayYes() {
  $("#edit-end-hour").val(23);
  $("#edit-end-minute").val(59);
  $("#edit-start-hour").val(0);
  $("#edit-start-minute").val(0);
  $("div.time").attr("style", "display: none;");
}

function EventAllDayNo() {
  $("div.time").removeAttr("style");
}
