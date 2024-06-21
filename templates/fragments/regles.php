<?php

// fragment pour les regles

?>

<h2>Règles du jeu</h2>

<h3>TRANSFORMER UN POINT (FORCE OU RÉSISTANCE)</h3>
<p>La transformation d’un point de force en point de résistance, ou réciproquement, consomme 3 points d’agilité.</p>
<p>Cela ne permet pas de dépasser 15 points de force ou 15 points de résistance.</p>
<h3>DÉPLACEMENTS</h3>
<h4>Déplacement vers l'avant :</h4>
<p>Un déplacement vers l'avant (dans la pièce suivante ou la zone de sortie) consomme des points d'agilité : il faut autant de
points d'agilité que le numéro de la pièce à atteindre, et 10 points pour passer dans la zone de sortie.</p>
<p>Si on n'a pas assez de points d'agilité, on n'a pas accès à la pièce suivante</p>
<h4>Déplacement vers l'arrière :</h4>
<p>Un déplacement vers l'arrière (dans la pièce précédente ou la zone d'entrée) est toujours possible et ne consomme pas de points d'agilité.</p>
<p>On peut le faire même avec zéro point d'agilité.</p>
<p>On gagne alors en points de vie le numéro de la pièce atteinte.</p>
<h3>RESTER DANS UNE PIÈCE SANS RIEN FAIRE</h3>
<p>Si on reste dans une pièce sans rien faire (sans attaquer) pendant 3 secondes, on récupère 1 point d'agilité.</p>
<p>Cela ne s'applique pas à la zone d'entrée.</p>  
<p>Attention : les points d'agilité sont plafonnés à 15 !</p>
<h3>ATTAQUER</h3>
<p>Lorsqu'on clique sur un personnage (donc présent dans la même pièce), cela signifie qu'on l'attaque.</p>
<p>L'attaque est alors automatique, et se fait avec une force déterminée et que l'on ne peut pas choisir (cette force
d’attaque est utilisée pour déterminer le déroulement du combat, voir chapitre suivant) : la force de l’attaque est la force
de l’attaquant.</p>
<p>Si l’adversaire esquive et que l’on a 10 points de force ou plus, un point de force devient un point de résistance.</p>
<p>Si on gagne le combat, on récupère un point d'agilité (ça motive ! ), ou un point de vie si on a déjà 15 points d'agilité.</p>
<p>Si on gagne le combat et que en plus l'on tue l'adversaire, on récupère en plus les points de vie qui lui restaient juste
avant le combat.</p>
<p>Si on perd le combat : on perd 1 point de vie.</p>
<h3>SUBIR UNE ATTAQUE</h3>
<p>Lorsque l'on subit une attaque d'une certaine force, on se défend, voire on riposte.</p>
<p>On peut donc subir une attaque alors même que l'on n'est pas connecté.</p>
<p>Cette opération est automatique (et apparait dans l'historique de l'utilisateur).</p>
<p>Si notre agilité dépasse la force d'attaque d'au moins 3 points, on esquive. Personne n'a alors gagné ou perdu le combat,
et on perd 1 point d'agilité.</p>
<p>Si notre force est supérieure strictement à celle de l'attaque, on riposte : voir ci-après la riposte. On gagne le combat et
un point de vie si on gagne la riposte, on perd le combat et 2 points de vie si on perd la riposte.</p>
<p>Sinon, on se défend : si notre résistance est supérieure ou égale à la force de l'attaque, on gagne le combat, si elle est
inférieure, on le perd et on perd en points de vie la différence entre notre résistance et la force de l'attaque.</p>
<h3>RIPOSTE</h3>
<p>La riposte fonctionne comme une attaque, mais est déclenchée automatiquement.</p>
<p>On attaque alors notre attaquant avec toute notre force disponible, et notre attaquant applique les règles "subir une
attaque".</p>



