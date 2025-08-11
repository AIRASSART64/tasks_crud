document.querySelectorAll(".status").forEach(label => {
  const text = label.textContent.trim().toLowerCase();

  label.classList.remove("statusRed", "statusBlue", "statusGrey");

  if (text === "à faire") {
    label.classList.add("statusRed");
  } else if (text === "en cours") {
    label.classList.add("statusBlue");
  } else if (text === "terminée") {
    label.classList.add("statusGrey");
  }
});

document.querySelectorAll(".priority").forEach(label => {
  const text = label.textContent;

  label.classList.remove("priorityRed", "priorityBlue", "priorityGrey");

  if (text === " Priorité : haute") {
    label.classList.add("priorityRed");
  } else if (text === " Priorité : moyenne") {
    label.classList.add("priorityBlue");
  } else if (text === " Priorité : basse") {
    label.classList.add("priorityGrey");
  }
});