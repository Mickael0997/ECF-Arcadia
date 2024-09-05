/* ---------- IMPORTATION DE LA CLASSE ROUTE ET DES VARIABLES --------- */

import Route from "./Route.js";
import { allRoutes, websiteName } from "./allRoutes.js";

// Création d'une route pour la page 404 (page introuvable)
const route404 = new Route("404", "Page introuvable", "/PAGES/404.htm");

// Fonction pour récupérer la route correspondant à une URL donnée
const getRouteByUrl = (url) => {
  const currentRoute = allRoutes.find((element) => element.url == url);
  return currentRoute || route404;
};

// Fonction pour charger le contenu de la page
const LoadContentPage = async () => {
  const path = window.location.pathname;

  // Récupération de l'URL actuelle
  const actualRoute = getRouteByUrl(path);

  try {
    const response = await fetch(actualRoute.pathHtml);
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    const html = await response.text();

    // Ajout du contenu HTML à l'élément avec l'ID "main-page"
    document.getElementById("main-page").innerHTML = html;

    // Ajout du contenu JavaScript
    if (actualRoute.pathJS != "") {
      const scriptTag = document.createElement("script");
      scriptTag.setAttribute("type", "text/javascript");
      scriptTag.setAttribute("src", actualRoute.pathJS);

      // Ajout de la balise script au corps du document
      document.querySelector("body").appendChild(scriptTag);
    }
  } catch (e) {
    console.log('There was a problem with the fetch operation: ' + e.message);
  }
};

// Appel de la fonction pour charger le contenu de la page
LoadContentPage();