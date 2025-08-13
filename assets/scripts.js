document.querySelectorAll(".status").forEach(label => {
  const text = label.textContent.trim().toLowerCase();

  label.classList.remove("statusRed", "statusBlue", "statusGrey");

  if (text.includes("à faire")) {
    label.classList.add("statusRed");
  } else if (text.includes("en cours")) {
    label.classList.add("statusBlue");
  } else if (text.includes("terminée")) {
    label.classList.add("statusGrey");
  }
});

document.querySelectorAll(".priority").forEach(label => {
  const text = label.textContent;

  label.classList.remove("priorityRed", "priorityBlue", "priorityGrey");

  if (text.includes("haute")) {
    label.classList.add("priorityRed");
  } else if (text.includes("moyenne")) {
    label.classList.add("priorityBlue");
  } else if (text.includes("basse")) {
    label.classList.add("priorityGrey");
  }
});
