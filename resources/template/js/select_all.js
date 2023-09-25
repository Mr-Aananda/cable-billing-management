function checkAll(event, input) {
  for (var i = 0; i < input.length; i++) {
      if (event.target.checked) {
          input[i].checked = true;
      } else {
          input[i].checked = false;
      }
  }

}