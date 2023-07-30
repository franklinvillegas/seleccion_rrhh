<template>
    <div class="p-3 pt-5">
        <div class="col-md-12" style="margin-left: -15px;">
            <h4 class="text-color-2 mb-3">Registro de Notas</h4>
        </div>
        <br>
        <!--  <div class="row justify-content-md-center">
           <div class="col-md-5">
                <div class="form-group">
                    <label for="">Tipo</label>
                    <select name="" class="form-control" v-model="listarSecciones.filtrosBusqueda.tipo" @change="listarNivel" > 
                        <option value="">-- Todos -- </option>
                        <option value="1">Inicio</option>
                        <option value="2">Pregunta</option>
                        <option value="3">Publicación</option>
                    </select>
                </div>
            </div>  
        </div>
        <hr> -->

        <!-- <hr>
        <button class="btn btn-outline-secondary float-right" type="button" @click="exportar">
            <i class="fas fa-download"></i>
            Exportar 
        </button>
        <br> -->


        <div class="tab-pane fade show active" id="paso1" role="tabpanel" aria-labelledby="paso1-tab">
            <div class="row">
                
                <div class="form-group col-3">
                    <p class="m-0">
                        <strong>Convocatoria</strong>
                    </p>
                    <select name="convocatoria" v-model="idConvocatoria" class="form-control" data-vv-as="Convocatoria"
                    placeholder="Seleccione Convocatoria" v-validate="'required'">
                    <option v-for="row in listarConvocatorias" :key="row.id" :value="row.id" v-text="row.nombre"></option>
                </select>
                    <span class="text-danger">{{ errors.first("form_registro.convocatoria") }}</span>
                </div>
                <div class="form-group col-3">
                    <p class="m-0">
                        <strong>Generar registro de notas</strong>
                    </p>
                    <button class="btn btn-outline-success float-left" type="button" @click="generarLista"> Generar
                    </button>
                </div>

            </div>
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Listado</legend>
                <div class="control-group">
                    <div class="table-responsive">
                        <vue-good-table :columns="listarRegistros.columns" :rows="listarRegistros.data" :search-options="{
                            enabled: true,
                            placeholder: 'Buscar en la tabla',
                        }">
                            <template slot="table-row" slot-scope="props">
                                <span v-if="props.column.field == 'index'">
                                    {{ props.index + 1 }}
                                </span>
                                <span v-if="props.column.field == 'nombre_completo'">
                                    {{ props.row.matricula.estudiante.persona.apellido_pat }}
                                    {{ props.row.matricula.estudiante.persona.apellido_mat }}
                                    {{ props.row.matricula.estudiante.persona.nombres }}
                                </span>
                                <span v-if="props.column.field == 'nota'">
                                    <input type="text" v-model="props.row.nota" class="form-control" data-vv-as="Documento"
                                        placeholder="Documento" name="num_docid"
                                        @keyup.enter="modificarNota(props.row.id, props.row.nota, props.row.observacion)">
                                </span>
                                <span v-if="props.column.field == 'observacion'">
                                    <input type="text" v-model="props.row.razon" class="form-control"
                                        data-vv-as="observacion" placeholder="observacion" name="num_docid"
                                        @keyup.enter="modificarNota(props.row.id, props.row.nota, props.row.observacion)">
                                </span>
                            </template>
                        </vue-good-table>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="tab-pane fade" id="paso2" role="tabpanel" aria-labelledby="paso2-tab">

        </div>
        <div class="tab-pane fade" id="paso3" role="tabpanel" aria-labelledby="paso3-tab">

        </div>
    </div>
</template>

<script>

import Helper from "../../services/Helper";

export default {
    name: 'Ayudas',
    components: {
    },
    data() {
        return {
            idConvocatoria: '',
            idProcincia: 1,

            listarConvocatorias: [],
            listarRegistros: {
        data: [],
        columns: [
          { label: "Sede Regional", field: "region" },
          { label: "Sede Provincial", field: "provincia" },
          { label: "N° Documento", field: "documento" },
          { label: "Apellido Paterno", field: "apellido_pat" },
          { label: "Apelldio Materno", field: "apellido_mat" },
          { label: "Nombres", field: "nombres" },
          { label: "Numero Registro", field: "num_registro" },
          { label: "Fecha Registro", field: "created_at" },
        ],
        total: 0,
        filtrosBusqueda: {
          tipo: "",
          orden: "asc",
          ordenPor: "id",
          regPagina: "10",
        },

        deshabilitarEdicion: false,
      },
        }
    },
    created() {
        this.listarConvocatoria();

    },
    methods: {
        listarConvocatoria() {
            axios.get("api/convocatoria/listar")
                .then((response) => {
                    let data = response.data;
                    this.listarConvocatorias = data;
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                });
        },
        
        limpiarFormulario() {
            this.modal = {
                titulo: '',
                nivelID: null,
                seccion: {
                    seccion: '',
                },
                deshabilitado: false,
            }
            this.$validator.reset();
        },
        guardar() {
            this.$validator.validateAll('form_registro').then(result => {
                if (result) {
                    axios.post("api/nivel/crear", this.modal.nivel)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-nivel").modal('hide');
                            this.listarNivel();
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                }
            });
        },
        modificar() {
            this.$validator.validateAll('form_registro').then(result => {
                if (result) {
                    axios.put("api/nivel/modificar/" + this.modal.nivelID, this.modal.nivel)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-nivel").modal('hide');
                            this.listarNivel();
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                }
            });
        },
        modificarNota(id, nota, razon) {
            const data = {
                nota,
                razon,
            }
            axios.put("api/notas/modificar/" + id, data)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    this.generarLista();
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                });

        },
        eliminar(row, index) {
            this.$confirm("¿Esta seguro de eliminar el registro?").then(() => {
                //
                axios.put("api/nivel/eliminar/" + row.id)
                    .then((response) => {
                        this.$toastr.s(response.data.message);
                        row.activo = false;
                    })
                    .catch((error) => {
                        this.$toastr.e(error.response.data.message);
                    });
                this.listarNivel();
            });

        },
        activar(row, index) {
            axios.put("api/nivel/activar/" + row.id)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    row.activo = true;
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
        },
        generarLista() {
            let datos ={
                convocatoria : this.idConvocatoria,
                provincia : this.idProcincia,
            }
            this.$validator.validateAll('form_registro').then(result => {
                if (result) {
                    axios.post("api/examen/generar", datos)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            console.log(response.data);
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                }
            });
        },
        obtenerTipo(row) {
            if (row.tipo == 1) return 'Inicio';
            else if (row.tipo == 2) return 'Pregunta';
            else if (row.tipo == 1) return 'Publicación';

        },
        exportar() {
            let url = process.env.MIX_APP_URL + '/exportar/ocupaciones' + Helper.getFilterURL(this.listarSecciones.filtrosBusqueda);
            window.open(url);
        }

    },
}
</script>
<style >
fieldset.scheduler-border {
    border: 1px solid #dee2e6 !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow: 0px 0px 0px 0px #000;
    box-shadow: 0px 0px 0px 0px #000;
}

legend.scheduler-border {
    font-size: 1rem !important;
    font-weight: bold !important;
    text-align: left !important;
    border: none;
    width: 120px;
}
</style>