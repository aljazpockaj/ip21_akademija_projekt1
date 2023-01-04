
# Pravilni načini uporabe
Obstajata dva načina za iskanje naših rezultatov, seveda odvisno od naših želja. 

Če želim dostopati do seznama mačk, v parametre napišemo list cats. V primeru, da želimo dostopati do psov napišemo list dogs. V kolikor želimo dostopati do obeh seznamov, to naredimo z ukazom list both. 

V kolikor želim dostopati do določene pasme, to naredimo z ukazom search dogs/cats "ime pasem" (Primer: search dogs husky).

# Nepravilni načini uporabe

Ko vnašamo parametre za search, je potrebno vnesti vedno tri parametre. V kolikor vnesemo samo dva (brez imena, npr. search dogs) nas program obvesti z "Nisi vnesel imena.".
Če podamo samo en parameter, to je search, nas program obvesti: "Nisi vnesel pravilnega tipa živali." . Hkrati nas obvesti kot prej, da nismo vnesli imena.
Ko ni noben parameter podan, se program ne zažene.

Pri uporabi parametra list, je potrebno vedno dodati dva parametra. V primeru da vnesemo samo list, oziroma napačen parameter, nas program obvesti, da nismo vnesli pravilnega tipa živali. 

# Absurdni načini uporabe

Če v parameter imena vnesemo več kot 20 znakov(primer: search dogs huuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuusky), nas program obvesti z "Ime je predolgo. Maksimalna dolžina je 20 znakov.". 
V primeru, da vnesemo ime, ki ne obstaja, oz. ni rezultatov našega iskanja, nas program obvesti z "Ni rezultatov vašega iskanja."