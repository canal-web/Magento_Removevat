# Magento_Removevat

Au moment où Magento a calculé le montant de la TVA (quelle que soit la page qui la demande) :
- si le pays de livraison du client est le même que le pays du marchand (repris dans le back-office), on ne fait rien.
- sinon, si le client a un numéro de TVA et qu'il est valide, on passe le montant précédemment calculé à 0€.
- dans tous les autres cas on ne touche à rien.

Le but est de profiter à la fois des group prices et de l'exonération de TVA.
