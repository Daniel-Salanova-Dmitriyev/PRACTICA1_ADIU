//Creamos un mapa de productos, donde clave es el nombre y valor es la cantidad
let productos = new Map();

fetch('https://fakestoreapi.com/carts')
    .then(res=>res.json())
    .then(json=> {
        json.forEach(carrito => {
            let arrayProductos = carrito.products;
            arrayProductos.forEach(element => {
                if(!productos.get(element.productId)){ //No existe el elemento en el mapa
                    productos.set(element.productId, element.quantity);
                }else{
                    let cantidad = productos.get(element.productId);
                    productos.set(element.productId, cantidad+element.quantity);
                }
            });
        });   
        //Obtenemos 2 mapIterators de claves y valores
        let nombresProductos = productos.keys();
        let valoresProductos = productos.values();
        //Obtenemos la longitud del mapa
        const length = Array.from(nombresProductos).length;
        nombresProductos = productos.keys(); //Actualizamos las claves, ya que con el anterior nos cambia la variable
        //Colocamos los valores
        let valoresSeries = []; //Será un array con objetos {nombre, densidad}
        let i = 0;
        for(const e of valoresProductos){
            let serie = {name:"", data:[].fill(0,0,length)};
            for(j = 0; j<length; j++){
                if(i==j){
                    serie.data.push(e);
                }else{
                    serie.data.push(0);
                }
            }
            
            i++;
            valoresSeries.push(serie);
        }
        //Colocamos los nombres
        i=0;
        for(const nombre of nombresProductos){
            valoresSeries[i++].name = "Producto " + nombre;
        }
        
        //Una vez que hemos filtrado los datos en un Mapa con las densidades de cada productId
        const chart = Highcharts.chart('container', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Productos comprados'
            },
            xAxis: {
                categories: nombresProductos
            },
            yAxis: {
                title: {
                    text: 'Compras'
                }
            },
            series: valoresSeries
        });
    
        }
    
    )

$(document).ready(function () {
    $.get("Test/server.php", function (data) {
        console.log("Datos recibidos:", data);
        let mapa = [];

        const nacionalidadData = data.nacionalidad.map(item => ({
          continente: item.Continente,
          name: item.Nacionalidad,
          y: parseInt(item.TotalPedidos)
        }));

        console.log(nacionalidadData);
  
        const ciudadData = data.ciudad.map(item => ({
          name: item.Ciudad,
          y: parseInt(item.TotalPedidos)
        }));
  
        // {name: CONTINENTE, data: {{name: PAIS, value: VALOR}}}
        const continentMap = new Map();

        // Agrupamos los datos por continente usando un Map
        nacionalidadData.forEach(item => {
          console.log(item);
          if (!continentMap.has(item.continente)) {
            // Si el continente no existe en el mapa, lo añadimos con un array vacío
            continentMap.set(item.continente, []);
          }
          
          // Agregamos el país al continente correspondiente
          continentMap.get(item.continente).push({
            name: item.name,
            value: parseInt(item.y, 10) // Convertimos TotalPedidos a número
          });
        });
        
        // Convertimos el Map al formato requerido
        const mapaContinentesPedidos = Array.from(continentMap, ([continent, countries]) => ({
          name: continent,
          data: countries
        }));
        
        // Generar gráfico para nacionalidad
        Highcharts.chart('grafico1', {
          chart: {
              type: 'packedbubble',
              height: '100%'
          },
          title: {
              text: 'Pedidos por continente',
              align: 'left'
          },
          tooltip: {
              useHTML: true,
              pointFormat: '<b>{point.name}:</b> {point.value} pedidos'
          },
          plotOptions: {
              packedbubble: {
                  minSize: '30%',
                  maxSize: '120%',
                  zMin: 0,
                  zMax: 1000,
                  layoutAlgorithm: {
                      splitSeries: false,
                      gravitationalConstant: 0.02
                  },
                  dataLabels: {
                      enabled: true,
                      format: '{point.name}',
                      filter: {
                          property: 'y',
                          operator: '>',
                          value: 250
                      },
                      style: {
                          color: 'black',
                          textOutline: 'none',
                          fontWeight: 'normal'
                      }
                  }
              }
          },
          series: mapaContinentesPedidos
      });

        
  
        // Generar gráfico para ciudad
        Highcharts.chart('grafico2', {
          chart: { type: 'pie' },
          title: { text: 'Pedidos por ciudad' },
          series: [{
            name: 'Ciudades',
            colorByPoint: true,
            data: ciudadData
          }]
        });
      }).fail(function (xhr, status, error) {
        console.error("Error al obtener los datos: " + error);
      });
});
