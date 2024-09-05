/* ---------- CREATION TABLEAU allRoutes POUR TOUTES LES ROUTES DU SITE ET DEFINIT LA VARIABLE websiteName ---------- */

import Route from "./Route.js";

//Définir ici vos routes
export const allRoutes = [
    new Route("/", "Accueil", "/PAGES/Home.htm"),
    new Route("/", "test", "/PAGES/test.htm"),
];

//Le titre s'affiche comme ceci : Route.titre - websitename
export const websiteName = "Le Zoo D'Arcadia";
