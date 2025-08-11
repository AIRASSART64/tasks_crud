  const label = document.getElementById("status");
  const text = label.textContent;

  label.classList.remove("statusRed", "statusBlue", "statusGrey");


  if (text === "à faire") {
    label.classList.add("statusRed");
  } else if (text === "en cours") {
    label.classList.add("statusBlue");
  } else if (text === "terminée") {
    label.classList.add("statusGrey");
  }