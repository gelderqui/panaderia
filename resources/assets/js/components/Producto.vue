<template>
            <main class="main">
<br><br>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Producto
                        <button type="button" @click="abrirModal('producto','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="codigo">Codigo</option>
                                      <option value="idclase">Clase</option>
                                    </select>
                                    <select v-if="criterio==='idclase'" class="form-control col-md-3" v-model="buscar" @click="listarProducto(1,buscar,criterio)">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="clas in arrayClase" :key="clas.id" :value="clas.id" v-text="clas.nombre"></option>
                                    </select>
                                     
                                    <input v-else type="text" v-model="buscar" @keyup.enter="listarProducto(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarProducto(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Codigo</th>
                                    <th>Costo</th>
                                    <th>Precio Venta Sucursal</th>
                                    <th>Precio Venta Franquicia</th>
                                    <th>Estado Temporada</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="producto in arrayProducto" :key="producto.id">
                                    <td>
                                        <button type="button" @click="abrirModal('producto','actualizar',producto)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="producto.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarProducto(producto.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarProducto(producto.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="producto.nombre"></td>
                                    <td v-text="producto.nombre_clase"></td>
                                    <td v-text="producto.codigo"></td>
                                    <td v-text="producto.costo"></td>
                                    <td v-text="producto.preciosucursal"></td>
                                    <td v-text="producto.preciofranquicia"></td>
                                    <td>
                                        <div v-if="producto.condiciontemporada">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                    <td>
                                        <div v-if="producto.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Clase</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idclase">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="clase in arrayClase" :key="clase.id" :value="clase.id" v-text="clase.nombre"></option>
                                        </select>                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del producto">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Codigo</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="codigo" class="form-control" placeholder="Codigo de producto">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Costo</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="costo" class="form-control" placeholder="">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Precio Sucursal</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="preciosucursal" class="form-control" placeholder="">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Precio Franquicia</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="preciofranquicia" class="form-control" placeholder="">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Temporada</label>
                                    <select class="form-control col-md-3" v-model="condiciontemporada">
                                      <option value="0">Desactivado</option>
                                      <option value="1">Activado</option>
                                    </select>
                                </div>
                                <div v-show="errorProducto" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjProducto" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarProducto()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarProducto()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
    export default {
        data (){
            return {
                arrayProducto : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : '',
                arrayClase :[],
                modal : 0,
                tipoAccion : 0,
                tituloModal : '',
                idclase : 0,
                nombre_clase : '',
                nombre : '',
                codigo : '',
                costo : 0,
                preciosucursal : 0,
                preciofranquicia : 0,
                condiciontemporada: 0,
                producto_id: 0,
                errorProducto : 0,
                errorMostrarMsjProducto : []
                
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {
            listarProducto (page,buscar,criterio){
                let me=this;
                var url= '/producto?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayProducto = respuesta.productos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectClase(){
                let me=this;
                var url= '/clase/selectClase';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayClase = respuesta.clases;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarProducto(page,buscar,criterio);
            },
            registrarProducto(){
                if (this.validarProducto()){
                    return;
                }
                
                let me = this;

                axios.post('/producto/registrar',{
                    'idclase': this.idclase,
                    'nombre': this.nombre,
                    'codigo': this.codigo,
                    'costo': this.costo,
                    'preciosucursal': this.preciosucursal,
                    'preciofranquicia': this.preciofranquicia,
                    'condiciontemporada': this.condiciontemporada
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarProducto(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarProducto(){
               if (this.validarProducto()){
                    return;
                }
                
                let me = this;

                axios.put('/producto/actualizar',{
                    'idclase': this.idclase,
                    'nombre': this.nombre,
                    'codigo': this.codigo,
                    'costo': this.costo,
                    'preciosucursal': this.preciosucursal,
                    'preciofranquicia': this.preciofranquicia,
                    'condiciontemporada': this.condiciontemporada,
                    'id': this.producto_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarProducto(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarProducto(id){
               swal({
                title: '¿Esta seguro de desactivar este producto?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/producto/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarProducto(1,'','nombre');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            activarProducto(id){
               swal({
                title: '¿Esta seguro de activar este producto?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/producto/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarProducto(1,'','nombre');
                        swal(
                        '¡Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            validarProducto(){
                this.errorProducto=0;
                this.errorMostrarMsjProducto =[];

                if (this.idclase==0) this.errorMostrarMsjProducto.push("Seleccione una clase.");
                if (!this.nombre) this.errorMostrarMsjProducto.push("El nombre no puede estar vacío.");
                if (!this.codigo) this.errorMostrarMsjProducto.push("Ingrese codigo.");
                if (!this.costo) this.errorMostrarMsjProducto.push("El costo tiene que ser un numero y no estar vacio.");
                if (!this.preciofranquicia) this.errorMostrarMsjProducto.push("El precio sucursal del debe ser un número y no puede estar vacío.");
                if (!this.preciosucursal) this.errorMostrarMsjProducto.push("El precio fanquicia debe ser un número y no puede estar vacío.");
                if (this.errorMostrarMsjProducto.length) this.errorProducto = 1;

                return this.errorProducto;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.idclase= 0;
                this.nombre_clase = '';
                this.nombre = '';
                this.codigo = '';
                this.costo = 0;
                this.preciosucursal = 0;
                this.preciofranquicia = 0;
		        this.errorArticulo=0;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "producto":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tipoAccion = 1;
                                this.tituloModal = 'Registrar Producto';
                                this.idclase=0;
                                this.nombre_clase='';
                                this.nombre='';
                                this.codigo= '';
                                this.costo=0;
                                this.preciosucursal=0;
                                this.preciofranquicia=0;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Producto';
                                this.tipoAccion=2;
                                this.producto_id=data['id'];
                                this.idclase=data['idclase'];
                                this.nombre=data['nombre'];
                                this.codigo = data['codigo'];
                                this.costo=data['costo'];
                                this.preciosucursal=data['preciosucursal'];
                                this.preciofranquicia=data['preciofranquicia'];
                                this.condiciontemporada=data['condiciontemporada'];
                                break;
                            }
                        }
                    }
                }
                this.selectClase();
            }
        },
        mounted() {
            this.listarProducto(1,this.buscar,this.criterio);
            this.selectClase();
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
