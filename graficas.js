
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
        let total = 0;

        for(const e of valoresProductos){
            total += e;
        }

        console.log("Total productos = " + total);
        valoresProductos = productos.values();
        //Colocamos los valores
        let valoresSeries = []; //Será un array con objetos {nombre, densidad}
        let i = 0;
        for(const e of valoresProductos){
            let serie = {name:"", y:0};

            for(j = 0; j<length; j++){
                if(i==j){
                    serie.y = ((e/total)*100);
                }
            }

            i++;
            valoresSeries.push(serie);
        }

        //Colocamos los nombres
        i=0;
        for(const v of nombresProductos){
            valoresSeries[i++].name = "Producto " + v;
        }

        console.log(valoresSeries);
        
        //Una vez que hemos filtrado los datos en un Mapa con las densidades de cada productId
        const chart = Highcharts.chart('container', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Porcentaje de ventas en articulos'
            },
            tooltip: {
                valueSuffix: '%'
            },
            subtitle: {
                text:
                'Source:<a href="https://fakestoreapi.com/" target="_default">Fake Store Api</a>'
            },
           /* plotOptions: {
                series: {
                    allowPointSelect: false,
                    cursor: 'pointer',
                    dataLabels: [{
                        enabled: false,
                        distance: 20
                    }, {
                        enabled: false,
                        distance: -40,
                        //format: '{point.percentage:.1f}%',
                        style: {
                            fontSize: '1.2em',
                            textOutline: 'none',
                            opacity: 0.7
                        },
                        filter: {
                            operator: '<',
                            property: 'percentage',
                            value: 10
                        }
                    }]
                }
            },*/
            series: [
                {
                    name: 'Percentage',
                    colorByPoint: true,
                    data: valoresSeries
                }
            ]
        });
    
        }
    
    )