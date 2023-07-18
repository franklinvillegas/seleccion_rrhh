<template>
    <div class="p-3 pt-5">
         <div class="col-md-12" style="margin-left: -15px;">
        <h4 class="text-color-2 mb-3">Información de Alumno</h4></div>
        <template>
            <div class="row p-t">
                            <form class="form d-flex flex-wrap" data-vv-scope="form_registro">
                                <div class="form-group col-md-4">
                                    <div>
                                    <p class="mb-05">
                                        <strong>Tipo de Documento</strong>
                                    </p>
                                    <span name="tipo_documento"
                                    v-text="modal.persona.documento.tipo"
                                    ></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div>
                                    <p class="mb-05">
                                        <strong>Documento</strong>
                                    </p>
                                    <span v-text="modal.persona.num_docid"></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div>
                                    <p class="mb-05">
                                        <strong>Apellido Paterno</strong>
                                    </p>
                                    <span v-text="modal.persona.apellido_pat"></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div>
                                    <p class="mb-05">
                                        <strong>Apellido Materno</strong>
                                    </p>
                                    <span v-text="modal.persona.apellido_mat"></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div>
                                    <p class="mb-05">
                                        <strong>Nombres</strong>
                                    </p>
                                    <span v-text="modal.persona.nombres"></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div>
                                    <p class="mb-05">
                                        <strong>Sexo</strong>
                                    </p>
                                    <span v-text="modal.persona.sexo"></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div>
                                    <p class="mb-05">
                                        <strong>Telefono 1</strong>
                                    </p>
                                    <span v-text="modal.persona.telefono1"></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div>
                                    <p class="mb-05">
                                        <strong>Telefono 2</strong>
                                    </p>
                                    <span v-text="modal.persona.telefono2"></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div>
                                    <p class="mb-05">
                                        <strong>Fecha de Nacimiento</strong>
                                    </p>
                                    <span v-text="modal.persona.fecha_nac"></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div>
                                    <p class="mb-05">
                                        <strong>Dirección</strong>
                                    </p>
                                    <span v-text="modal.persona.direccion"></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <p class="mb-05">
                                        <strong>Talla (m)</strong>
                                    </p>
                                    <span v-text="modal.alumno.talla"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <p class="mb-05">
                                        <strong>Peso (Kg)</strong>
                                    </p>
                                    <span v-text="modal.alumno.peso"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="mb-05">
                                        <label for="alergias"> <strong>Alergias</strong></label>
                                    </div>
                                    <div v-if="modal.alumno.alergias==true">
                                        <span v-text="modal.alumno.detalle_alergia">
                                        </span>
                                    </div>
                                    <div v-else>
                                        <span>Ninguna</span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="mb-05">
                                        <label for="discapacidad"> <strong>Discapacidad</strong></label>
                                    </div>
                                    <div v-if="modal.alumno.discapacidad==true">
                                        <span v-text="modal.alumno.detalle_discapacidad"></span>
                                    </div>
                                    <div v-else>
                                        <span>Ninguna</span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="mb-05">
                                        <label for="enfermedad"><strong>Enfermedad</strong></label>
                                    </div>
                                    <div v-if="modal.alumno.enfermedad==true">
                                        <span v-text="modal.alumno.detalle_enfermedad"></span>
                                    </div>
                                    <div v-else>
                                        <span>Ninguna</span>
                                    </div>
                                </div>
                            </form>

            </div>
        </template>
    </div>
</template>

<script>

import Helper from "../../services/Helper";
import Crypt from "../../services/Crypt";

    export default {
        name:'Ayudas',
        components:{
        },
        data(){
            return{
                listaAlumnos:{
                    data: [],
                    columns:[
                        {label: 'N° Doc', field: 'persona.num_docid',},
                        {label: 'Apellidos y Nombres', field: 'nombre_completo' ,},
                        {label: 'Grado', field: 'grado',},
                        {label: 'Seccion', field: 'seccion',},
                        {label: 'Opciones', field: 'options',},
                    ],
                    total: 0,
                    filtrosBusqueda:{
                        tipo:'',
                        orden: 'asc',
                        ordenPor: 'id',
                        regPagina: '10',
                    },
                    deshabilitarEdicion: false,
                },
                listarTipoDocs:[],
                deshabilitado: false,
                modal:{
                    tipo: '',
                    titulo:  '',
                    tipo_documento: null,
                    existe:null,
                    alumno:{
                        talla:'',
                        peso:'',
                        alergias:'',
                        detalle_alergia:'',
                        discapacidad:'',
                        detalle_discapacidad:'',
                        enfermedad:'',
                        detalle_enfermedad:'',
                        otros:'',
                        estado:'',
                        id_per:'',
                    },
                    persona:{
                        id_docid:'',
                        nombres:'',
                        apellido_pat:'',
                        apellido_mat:'',
                        sexo:'FEMENINO',
                        telefono1:'',
                        telefono2:'',
                        fecha_nac:'',
                        num_docid:'',
                        direccion:'',
                        id_docid:'',
                        id_dist:'1',
                        documento:{
                            tipo:'',
                        }
                    },
                },

            }
        },
        created(){ ;
            this.ver();
            this.listarTipoDoc();

        },
        methods:{
            listarTipoDoc(){
                axios.get("api/documento/listar")
                .then((response) => {
                    let data = response.data;
                    this.listarTipoDocs = data;
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                });
            },
            listarAlumnos(){
                axios.get("api/alumno/listar"+Helper.getFilterURL(this.listaAlumnos.filtrosBusqueda))
                .then((response) => {
                    let data = response.data;
                    data.map(element => {
                        element.nombre_completo = element.persona.apellido_pat + " " + element.persona.apellido_mat + " " + element.persona.nombres;
                        return element;
                    });
                    this.listaAlumnos.data = data;
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                });
            },

            limpiarFormulario(){
                console.log('entro limpiar');
                this.modal={
                    tipo: '',
                    titulo:  '',
                    existe:null,
                    tipo_documento: null,
                    alumno:{
                        talla:'',
                        peso:'',
                        alergias:false,
                        detalle_alergia:'',
                        discapacidad:false,
                        detalle_discapacidad:'',
                        enfermedad:false,
                        detalle_enfermedad:'',
                        otros:'',
                        estado: 1,
                        id_per:'',
                    },
                    persona:{
                        id_docid:'',
                        nombres:'',
                        apellido_pat:'',
                        apellido_mat:'',
                        sexo:'FEMENINO',
                        telefono1:'',
                        telefono2:'',
                        fecha_nac:'',
                        num_docid:'',
                        direccion:'',
                        id_docid:'',
                        id_dist:'1',
                    },

                    deshabilitado: false,
                },
                this.$validator.reset();
            },
            limpiarFormularioBuscar(){
                this.modal={
                    tipo: '',
                    existe:null,
                    titulo:  'Nuevo Alumno',
                    alumno:{
                        talla:'',
                        peso:'',
                        alergias:false,
                        detalle_alergia:'',
                        discapacidad:false,
                        detalle_discapacidad:'',
                        enfermedad:false,
                        detalle_enfermedad:'',
                        otros:'',
                        estado: 1,
                        id_per:'',
                    },
                    persona:{
                        id_docid:'',
                        nombres:'',
                        apellido_pat:'',
                        apellido_mat:'',
                        sexo:'FEMENINO',
                        telefono1:'',
                        telefono2:'',
                        fecha_nac:'',
                        num_docid:this.modal.persona.num_docid,
                        direccion:'',
                        id_dist:'1',
                    },

                    deshabilitado: false,
                },
                this.$validator.reset();
            },
            nuevo(){
                $("#modal-Alumno").modal('show');
                this.limpiarFormulario();
                this.modal.titulo = 'Nuevo Alumno';
                this.modal.tipo = 'nuevo';

            },
            ver(){
                axios.get("api/alumno/ver")
                .then((response) => {
                    let data = response.data;
                    this.modal.alumno = data;
                    this.modal.persona=data.persona;
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                });
            },
            exportar(){
                let url = process.env.MIX_APP_URL + '/exportar/ocupaciones' + Helper.getFilterURL(this.listaAlumnos.filtrosBusqueda);
                window.open(url);
            },
            buscar(dni){
                console.log('dni',dni);
                        axios.get("api/persona/buscar/" + dni)
                        .then((response) => {
                            if (!response.data || response.data==''){
                            this.$toastr.w('La persona no se encuentra, continue con el registro');
                            this.limpiarFormularioBuscar()
                            this.modal.tipo='nuevo';
                            }
                            else{
                            this.modal.persona=response.data;
                            this.modal.alumno.id_per=response.data.id;
                            this.modal.existe=response.data.id;

                            }
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });

            },

        },
    }
</script>
<style >
  .modal-dialog{
      max-width: 800px;
  }
</style>
