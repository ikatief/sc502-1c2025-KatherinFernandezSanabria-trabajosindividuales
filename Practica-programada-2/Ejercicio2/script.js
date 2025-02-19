/*primer paso*/
function getAverage(scores) {
    let sum = 0;
  
    for (const score of scores) {
      sum += score;
    }
  
    return sum / scores.length;
  }
  
  /*segundo paso*/
  function getGrade(score) {
    if (score === 100) {
      return "A++";
    } else if (score >= 90) {
      return "A";
    } else if (score >= 80) {
      return "B";
    } else if (score >= 70) {
      return "C";
    } else if (score >= 60) {
      return "D";
    } else {
      return "F";
    }
  }
  
  /*tercer paso*/
  function hasPassingGrade(score) {
    return getGrade(score) !== "F";
  }
  
  /*cuarto paso*/
  function studentMsg(totalScores, studentScore) {
    if (getGrade(studentScore) !=="F") { 
  return "Class average: "+getAverage (totalScores)+". Your grade: "+ getGrade (studentScore)+". You passed the course." 
  }else{ 
  return "Class average: "+getAverage (totalScores)+". Your grade: "+getGrade (studentScore)+". You failed the course." 
  } 
  } 
  
  
  console.log(studentMsg([92, 88, 12, 77, 57, 100, 67, 38, 97, 89], 37));

  /*resultado

 ensayos de funcionamiento
Ensayos completados
salida de la consola
Promedio de clase: 71,7. Su calificación: F. Fracasaste el curso.*/
  