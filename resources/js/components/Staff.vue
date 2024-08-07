<template>
    <div class="flex flex-col p-8">
        <div class="flex justify-center text-2xl pb-4 no-print text-sky-600">
            จัดการข้อมูลสมาชิก
        </div>

        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8" ref="printRecord">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <table
                        class="min-w-full border text-center text-sm font-light"
                    >
                        <transition-group name="fade" mode="out-in">
                            <tbody
                                style="width: 100%; display: table"
                                v-if="showMember"
                            >
                                <!-- Header -->
                                <thead class="border-b bg-teal-700 text-white">
                                    <tr>
                                        <th
                                            scope="col"
                                            class="border-r py-2 font-normal"
                                        >
                                            #
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r py-2 font-normal"
                                        >
                                            UID
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r py-2 font-normal"
                                        >
                                            ชื่อ-นามสกุล
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r py-2 font-normal"
                                        >
                                            Overtime
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r py-2 font-normal"
                                        >
                                            สร้างโดย
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r py-2 font-normal"
                                        >
                                            เมื่อวันที่
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r py-2 font-normal"
                                        >
                                            เวลา
                                        </th>
                                    </tr>
                                </thead>

                                <!-- กลุ่มงาน -->
                                <thead
                                    v-for="(dep, index) in depList"
                                    :key="index"
                                >
                                    <tr>
                                        <th
                                            colspan="7"
                                            class="border-b p-2 font-normal text-left bg-sky-50"
                                        >
                                            <div class="grid grid-cols-2">
                                                {{ dep.dep_title }}
                                                <span class="flex justify-end">
                                                    <box-icon
                                                        name="plus-circle"
                                                        animation="tada-hover"
                                                        color="#84cc16"
                                                        class="hover:cursor-pointer"
                                                        @click="
                                                            showAdd(
                                                                dep.id,
                                                                dep.dep_title
                                                            )
                                                        "
                                                    ></box-icon>
                                                </span>
                                            </div>
                                        </th>
                                    </tr>

                                    <!-- รายชื่อ -->
                                    <tr
                                        class="border-b"
                                        v-for="(report, index) in showMember"
                                        :key="index"
                                    >
                                        <template v-if="report.dep === dep.id">
                                            <td
                                                class="whitespace-nowrap border-r py-2"
                                            >
                                                {{ index + 1 }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap border-r py-2"
                                            >
                                                {{ report.uid }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap border-r py-2"
                                            >
                                                {{ report.name }}
                                                {{ report.surname }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap border-r py-2"
                                                v-if="report.overtime === 1"
                                            >
                                                <box-icon
                                                    name="check-circle"
                                                    color="#84cc16"
                                                    class="hover:cursor-pointer"
                                                    @click="
                                                        sendUpdate(report.id)
                                                    "
                                                >
                                                </box-icon>
                                            </td>
                                            <td
                                                class="whitespace-nowrap border-r py-2 hover:cursor-pointer hover:bg-sky-50"
                                                v-else
                                                @click="sendUpdate(report.id)"
                                            ></td>
                                            <td
                                                class="whitespace-nowrap border-r py-2"
                                            >
                                                {{ report.created_by }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap border-r py-2"
                                            >
                                                {{
                                                    moment(report.created_at).add(543, "years").format("L")
                                                }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap border-r py-2"
                                            >
                                                {{
                                                    moment(report.created_at).format("LTS")
                                                }}
                                                น.
                                            </td>
                                        </template>
                                    </tr>
                                </thead>
                            </tbody>
                        </transition-group>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add -->
    <transition name="fade" mode="out-in">
        <div
            class="relative z-10"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
            v-show="modalAdd"
        >
            <div
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
            ></div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div
                    class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
                >
                    <form
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                        @submit.prevent="sendAdd()"
                    >
                        <div class="grid grid-cols-1 bg-white px-4 sm:p-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-lime-100 sm:mx-0 sm:h-10 sm:w-10"
                                >
                                    <box-icon name="barcode"></box-icon>
                                </div>
                                <div
                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                >
                                    <label
                                        id="listbox-label"
                                        class="block text-sm font-medium leading-6 text-gray-900"
                                        >UID :
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control block w-full px-3 py-1.5 rounded-lg text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-sky-300 focus:outline-none"
                                        required
                                        v-model="addData.uid"
                                        r
                                    />
                                </div>
                            </div>
                        </div>

                        <div
                            class="grid grid-cols-2 bg-white px-4 pb-4 sm:p-4 sm:pb-4"
                        >
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-lime-100 sm:mx-0 sm:h-10 sm:w-10"
                                >
                                    <box-icon name="user"></box-icon>
                                </div>
                                <div
                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                >
                                    <label
                                        id="listbox-label"
                                        class="block text-sm font-medium leading-6 text-gray-900"
                                        >ชื่อ :
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control block w-full px-3 py-1.5 rounded-lg text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-sky-300 focus:outline-none"
                                        required
                                        v-model="addData.name"
                                    />
                                </div>
                            </div>

                            <div class="sm:flex sm:items-start">
                                <div
                                    class="text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                >
                                    <label
                                        id="listbox-label"
                                        class="block text-sm font-medium leading-6 text-gray-900"
                                        >นามสกุล :
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control block w-full px-3 py-1.5 rounded-lg text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-sky-300 focus:outline-none"
                                        required
                                        v-model="addData.surname"
                                    />
                                </div>
                            </div>
                        </div>

                        <div
                            class="grid grid-cols-2 bg-white px-4 pb-4 sm:p-4 sm:pb-4"
                        >
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-lime-100 sm:mx-0 sm:h-10 sm:w-10"
                                >
                                    <box-icon name="detail"></box-icon>
                                </div>
                                <div
                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                >
                                    <label
                                        id="listbox-label"
                                        class="block text-sm font-medium leading-6 text-gray-900"
                                        >สังกัด/กลุ่มงาน :
                                    </label>
                                    <div
                                        class="border rounded-lg border-dashed border-lime-400 p-2"
                                    >
                                        {{ dep_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="sm:flex sm:items-start">
                                <div
                                    class="text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                >
                                    <label
                                        id="listbox-label"
                                        class="block text-sm font-medium leading-6 text-gray-900"
                                        >ประเภท :
                                    </label>
                                    <div class="relative">
                                        <select
                                            class="text-sm p-3 cursor-pointer block appearance-none w-full bg-white border border-gray-200 text-gray-700 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-sky-500"
                                            required
                                            v-model="addData.type"
                                        >
                                            <option disabled value="">
                                                กรุณาเลือก...
                                            </option>
                                            <option value="staff">
                                                บุคลากร
                                            </option>
                                            <option value="student">
                                                นิสิตฝึกงาน
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"
                        >
                            <button
                                type="submit"
                                class="inline-flex w-full justify-center rounded-md bg-green-400 px-3 py-2 text-sm text-white shadow-sm hover:bg-green-500 sm:ml-3 sm:w-auto"
                            >
                                บันทึกข้อมูล
                            </button>
                            <button
                                type="button"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm text-gray-900 shadow-sm hover:bg-gray-50 ring-1 ring-inset ring-gray-300 sm:mt-0 sm:w-auto"
                                @click="closeAdd()"
                            >
                                ออก
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import "boxicons";
import moment from "moment";
import axios from "axios";
import Swal from "sweetalert2";

export default {
    mounted() {
        this.getMember();
        this.getDep();
    },
    data() {
        return {
            logo: "/img/library.png",
            path: "/storage/img",
            picked: new Date(),
            show: true,
            modalEdit: false,
            modalAdd: false,
            report: {
                selected: "",
            },
            showMember: "",
            depList: "",
            moment: moment,
            addData: {
                uid: "",
                name: "",
                surname: "",
                dep: "",
                type: "",
            },
            dep_name: "",
        };
    },
    methods: {
        showAdd(id, code) {
            this.modalAdd = true;
            this.addData.dep = id;
            this.dep_name = code;

            console.log(this.addData.dep, this.addData.dep_name);
        },
        closeAdd() {
            this.modalAdd = false;
        },
        async getMember() {
            try {
                axios
                    .get("/api/member")
                    .then((response) => {
                        this.showMember = response.data;
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            } catch (err) {
                console.log(err);
            }
        },
        getDep() {
            axios
                .get("/api/dep")
                .then((response) => {
                    this.depList = response.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        async sendUpdate(id) {
            try {
                Swal.fire({
                    title: "แก้ไขสิทธิ์ล่วงเวลา ?",
                    text: "ต้องการแก้ไขสิทธิ์การทำงานล่วงเวลาหรือไม่",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "ใช่",
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .put("/api/member/" + id)
                            .then((response) => {
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: response.data.message,
                                    showConfirmButton: false,
                                    timer: 1500,
                                });
                                this.getMember();
                            })
                            .catch((err) => {
                                console.log(err);
                            });
                    }
                });
            } catch (err) {
                console.log(err);
            }
        },

        async sendAdd() {
            try {
                axios
                    .post("/api/member", this.addData)
                    .then((response) => {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: response.data.message,
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        this.modalAdd = false;
                        this.getMember();
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            } catch (err) {
                console.log(err);
            }
        },
    },
};
</script>

<style>
.boxplus:hover {
    color: red;
}
</style>
