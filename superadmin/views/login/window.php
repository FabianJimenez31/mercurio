hola {[custom_index]} <br> como {[custom_index|md5]} -> Debe Estar {[custom_index_2]}
<br>solo se muestra el valor que coincide con la clave inside_key {[custom_array][inside_key]}


hola!foreach {[custom_array_request]} as com!
<br> Usuario: {[com:user|upper]} / {[com:password|md5|upper]} /{[com:password|lower]} {[$(1)|+:2]} {[$(FORMULA EN VALOR PERSONALIZADO)|lower]}
!end com!




<br>{[$(FORMULA EN VALOR PERSONALIZADO)|lower]}

<br> Esto Dará una lista de usuarios unicamente:
hola!foreach {[custom_array_request]} as com2!
<br>- {[com2:user]}
!end com2!
