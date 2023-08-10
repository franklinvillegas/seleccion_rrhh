<template>
    <div class="p-3 pt-5">
        <div class="col-md-12" style="margin-left: -15px">

            <h4 class="text-color-2 mb-3">PRESELECCION: Reporte de  CV Evaluados</h4>
        </div>
        <br />
        <div class="form-group col-12">
            <div class=" col-4">
                <p class="m-0">
                    <strong>Convocatoria</strong>
                </p>
                <select name="convocatoria" v-model="idConvocatoria" class="form-control" data-vv-as="Convocatoria"
                    placeholder="Seleccione Convocatoria" v-validate="'required'">
                    <option v-for="row in listarConvocatorias" :key="row.id" :value="row.id" v-text="row.nombre"></option>
                </select>
                <!-- <span class="text-danger">{{errors.first("form_registro.nivel")}}</span> -->

                <button class="btn btn-outline-secondary float-right" type="button" @click="mostrar">
                    Mostrar
                </button>
                <!-- <button class="btn btn-outline-secondary float-right" type="button" @click="exportar">
                    reporte
                </button> -->
            </div>
        </div>
        <div class="table-responsive">
            <vue-good-table :columns="listarRegistros.columns" :rows="listarRegistros.data" :search-options="{
                enabled: true,
                placeholder: 'Buscar en la tabla',
            }" :pagination-options="{
                enabled: true,
                mode: 'pages',
                nextLabel: 'Sig',
                prevLabel: 'Ant',
                rowsPerPageLabel: 'Registros por página',
                ofLabel: 'de',
                pageLabel: 'Página', // for 'pages' mode
                allLabel: 'Todo',
            }">
            </vue-good-table>
        </div>
    </div>
</template>
  
<script>
import Helper from "../../services/helper";

export default {
    name: "Ayudas",
    components: {},
    data() {
        return {
            listarRegistros: {
                data: [],
                columns: [
                    { label: "Sede Regional", field: "region" },
                    { label: "Sede Provincial", field: "provincia" },
                    { label: "N° DNI", field: "documento" },
                    { label: "Apellidos y nombres", field: "datos" },
                    { label: "RNP", field: "rnp" },
                    { label: "Manejo de herramientas", field: "office" },
                    { label: "Lengua Originaria", field: "certificado_lengua" },
                    { label: "Maximo Grado Alcanzado", field: "grado" },
                    { label: "Experiencia Especifica", field: "criterio_cv_2" },
                    { label: "Experiendia general", field: "criterio_cv_3" },
                    { label: "Numero Registro", field: "num_registro" },
                    { label: "Fecha Registro", field: "created_at" },
                ],
                total: 0,
                filtrosBusqueda: {
                    tipo: "",
                    orden: "asc",
                    ordenPor: "datos",
                    regPagina: "10",
                    cargo: '',
                },

                deshabilitarEdicion: false,
            },
            idConvocatoria: '',


            listarConvocatorias: [],
        };
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
        mostrar() {
            axios
                .get("api/evaluacion/mostrarReporte/" + this.idConvocatoria)
                .then((response) => {
                    this.listarRegistros.data = response.data;
                    console.log(this.listarRegistros);
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                });
        },
        guardar() {
            this.$validator.validateAll("form_registro").then((result) => {
                if (result) {
                    axios
                        .post("api/grado/crear", this.modal.grado)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-grado").modal("hide");
                            this.listarGrado();
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                }
            });
        },
        excel() {
                    axios
                        .get("api/export/reporte_cv", this.idConvocatoria)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
        },
        exportar() {
            this.listarRegistros.filtrosBusqueda.cargo=this.idConvocatoria;
            let url =
                process.env.MIX_APP_URL +"/exportar/reporte_cv" +
        Helper.getFilterURL(this.listarRegistros.filtrosBusqueda);
      window.open(url);
        },
    },
};
</script>
<style ></style>
  