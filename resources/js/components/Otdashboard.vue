<template>
    <div class="flex flex-col p-8">
        <div class="flex justify-end pb-2 no-print">
            <form class="flex">
                <Datepicker
                    class="hover:cursor-pointer border rounded-lg p-2 text-right"
                    language="th"
                    v-model="picked"
                />
                <button
                    class="rounded-lg border ml-2 p-2 bg-green-200 hover:bg-green-300"
                    @click.prevent="search()"
                >
                    ค้นหา
                </button>
            </form>
        </div>

        <div class="flex justify-end" v-if="showDayList">
            <button
                class="px-4 pt-1 border shadow-lg rounded-lg bg-green-200 hover:bg-slate-300 mr-2"
                @click="addTime()"
            >
                <box-icon name="user-plus"></box-icon>
            </button>
            <button
                class="px-4 pt-1 border shadow-lg rounded-lg bg-slate-200 hover:bg-slate-300"
                @click.prevent="printReport()"
            >
                <box-icon name="printer"></box-icon>
            </button>
        </div>

        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8" ref="printRecord">
            <div class="text-center text-lg">
                <p>บัญชีลงเวลาการปฏิบัติงานนอกเวลาราชการ</p>
                <p>สำนักวิทยบริการ มหาวิทยาลัยมหาสารคาม</p>
                <p>
                    วันที่
                    {{
                        moment(this.report.selected)
                            .add(543, "years")
                            .format("LL")
                    }}
                </p>
            </div>

            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div
                    class="flex justify-end text-sm text-gray-400"
                    v-if="showDayList"
                >
                    ** Print from the libwork System by Academic Resource Center
                    MSU |
                    {{ moment().add(543, "years").format("LLL") }} น.
                </div>

                <div class="overflow-hidden mt-2">
                    <table
                        class="min-w-full border text-center text-sm font-light"
                    >
                        <transition-group name="fade" mode="out-in">
                            <tbody
                                style="width: 100%; display: table"
                                v-if="showDayList"
                            >
                                <!-- Header -->
                                <thead class="border-b bg-teal-700 text-white">
                                    <tr>
                                        <th
                                            scope="col"
                                            class="border-r py-2 px-2 font-normal"
                                        >
                                            #
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
                                            บริการ
                                        </th>
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
                                            เวลาเข้า
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r py-2 font-normal"
                                        >
                                            ลงลายมือชื่อ
                                        </th>
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
                                            เวลากลับ
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r py-2 font-normal"
                                        >
                                            ลงลายมือชื่อ
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r py-2 font-normal"
                                        >
                                            จำนวนช.ม.
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r py-2 font-normal"
                                        >
                                            หมายเหตุ
                                        </th>
                                    </tr>
                                </thead>

                                <!-- รายชื่อ -->
                                <tr
                                    class="border-b"
                                    v-for="(report, index) in showDayList"
                                    :key="index"
                                >
                                    <td class="whitespace-nowrap border-r py-2">
                                        {{ index + 1 }}
                                    </td>
                                    <td class="whitespace-nowrap border-r py-2">
                                        {{ report.name }}
                                        {{ report.surname }}
                                    </td>
                                    <td class="whitespace-nowrap border-r py-2">
                                        <!-- {{ report.otherin }} -->
                                        {{ showService(report.otherin) }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap border-r px-6 py-4"
                                    >
                                        <img
                                            v-if="report.picin"
                                            class="mx-auto rounded-full object-cover object-center h-8 w-8 cursor-pointer"
                                            alt=""
                                            :src="
                                                path +
                                                '/' +
                                                report.y +
                                                '/' +
                                                report.m +
                                                '/' +
                                                report.d +
                                                '/' +
                                                report.picin
                                            "
                                            @click="
                                                showImg(
                                                    report.y,
                                                    report.m,
                                                    report.d,
                                                    report.picin
                                                )
                                            "
                                        />
                                    </td>
                                    <td
                                        v-if="report.timein"
                                        class="whitespace-nowrap border-r py-2"
                                    >
                                        {{ report.timein }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap border-r py-2"
                                    ></td>
                                    <td
                                        class="whitespace-nowrap border-r px-6 py-4"
                                    >
                                        <img
                                            v-if="report.picout"
                                            class="mx-auto rounded-full object-cover object-center h-8 w-8 cursor-pointer"
                                            alt=""
                                            :src="
                                                path +
                                                '/' +
                                                report.y +
                                                '/' +
                                                report.m +
                                                '/' +
                                                report.d +
                                                '/' +
                                                report.picout
                                            "
                                            @click="
                                                showImg(
                                                    report.y,
                                                    report.m,
                                                    report.d,
                                                    report.picout
                                                )
                                            "
                                        />
                                    </td>

                                    <td
                                        v-if="report.timeout"
                                        class="whitespace-nowrap border-r py-2"
                                    >
                                        {{ report.timeout }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap border-r py-2"
                                    ></td>
                                    <td
                                        class="whitespace-nowrap border-r py-2"
                                    ></td>
                                    <td
                                        v-if="report.timeout"
                                        class="whitespace-nowrap border-r py-2 hover:bg-sky-100 hover:cursor-pointer"
                                        @click="
                                            editOther(
                                                report.idout,
                                                report.name,
                                                report.surname,
                                                report.dat,
                                                report.otherout
                                            )
                                        "
                                    >
                                        {{ report.otherout }}
                                    </td>
                                    <td
                                        v-else
                                        class="whitespace-nowrap border-r py-2"
                                    ></td>
                                </tr>
                                <tr v-for="n in 3" :key="n" class="border-b">
                                    <td
                                        v-for="m in 10"
                                        :key="m"
                                        class="whitespace-nowrap border-r py-6"
                                    ></td>
                                    <td class="whitespace-nowrap py-3"></td>
                                </tr>
                            </tbody>
                        </transition-group>
                    </table>
                </div>
                <div class="flex mt-8">
                    <!-- <p>มาปฏิบัติงานทั้งหมด <font class="px-6">{{ this.count }}</font> คน</p> -->
                    <p>มาปฏิบัติงานทั้งหมด ........................... คน</p>
                    <p class="pl-8">ไปราชการ ........................... คน</p>
                    <p class="pl-8">
                        ไม่มาปฏิบัติงาน ........................... คน
                    </p>
                </div>

                <div class="mt-12 text-center">
                    <p>
                        ลงชื่อ
                        ..............................................................
                        ผู้ควบคุม
                    </p>
                    <p>( {{ this.head }} )</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <transition name="fade" mode="out-in">
        <div
            class="relative z-10"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
            v-show="modalEdit"
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
                        @submit.prevent="sendEdit()"
                    >
                        <div
                            class="grid grid-cols-2 bg-white px-4 pb-4 sm:p-4 sm:pb-4"
                        >
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-amber-100 sm:mx-0 sm:h-10 sm:w-10"
                                >
                                    <box-icon name="user"></box-icon>
                                </div>
                                <div
                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                >
                                    <label
                                        id="listbox-label"
                                        class="block text-sm font-medium leading-6 text-gray-900"
                                        >วันที่
                                    </label>
                                    <div
                                        class="border-dotted border-2 rounded-lg p-2"
                                    >
                                        {{
                                            moment(this.editData.dat)
                                                .add(543, "years")
                                                .format("L")
                                        }}
                                    </div>
                                </div>
                            </div>

                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                >
                                    <label
                                        id="listbox-label"
                                        class="block text-sm font-medium leading-6 text-gray-900"
                                        >ชื่อ-นามสกุล :
                                    </label>
                                    <div
                                        class="border-dotted border-2 rounded-lg p-2"
                                    >
                                        {{ this.editData.name }}
                                        {{ this.editData.surname }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white px-4 pb-4 sm:p-4 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-amber-100 sm:mx-0 sm:h-10 sm:w-10"
                                >
                                    <box-icon name="time"></box-icon>
                                </div>
                                <div
                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                >
                                    <label
                                        id="listbox-label"
                                        class="block text-sm font-medium leading-6 text-gray-900"
                                        >หมายเหตุ :
                                    </label>
                                    <textarea
                                        class="border w-full rounded-lg p-2 focus:outline-none focus:ring-1 focus:border-blue-100"
                                        required
                                        v-model="editData.otherout"
                                    ></textarea>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"
                        >
                            <button
                                type="submit"
                                class="inline-flex w-full justify-center rounded-md bg-amber-400 px-3 py-2 text-sm text-white shadow-sm hover:bg-amber-500 sm:ml-3 sm:w-auto"
                            >
                                แก้ไขข้อมูล
                            </button>
                            <button
                                type="button"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm text-gray-900 shadow-sm hover:bg-gray-50 ring-1 ring-inset ring-gray-300 sm:mt-0 sm:w-auto"
                                @click="closeEdit()"
                            >
                                ออก
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </transition>

    <!-- Modal Add -->
    <transition name="fade" mode="out-in">
        <div
            class="relative z-10"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
            v-show="modalAddTimeIn"
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
                                        >วันที่
                                    </label>
                                    <div
                                        class="border-dotted border-2 rounded-lg p-2"
                                    >
                                        {{
                                            moment(this.report.selected)
                                                .add(543, "years")
                                                .format("L")
                                        }}
                                    </div>
                                </div>
                            </div>

                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                >
                                    <label
                                        id="listbox-label"
                                        class="block text-sm font-medium leading-6 text-gray-900"
                                        >ชื่อ-นามสกุล :
                                    </label>
                                    <div
                                        class="border-dotted border-2 rounded-lg p-2"
                                    >
                                        <button
                                            type="button"
                                            class="w-52 rounded-lg text-right"
                                            @click="showSelect = !showSelect"
                                        >
                                            {{ this.myname }}
                                            <box-icon
                                                name="chevron-down"
                                                size="xs"
                                                class="hover:cursor-pointer"
                                            ></box-icon>

                                            <transition
                                                name="fade"
                                                mode="out-in"
                                            >
                                                <ul
                                                    class="rounded-lg mt-4 p-2 overflow-hidden w-52 -mx-2 bg-white"
                                                    v-if="showSelect"
                                                >
                                                    <li
                                                        class="hover:bg-sky-400 hover:text-white rounded-lg"
                                                        v-for="(
                                                            member, index
                                                        ) in memberList"
                                                        :key="index"
                                                        @click="
                                                            choose(
                                                                member.uid,
                                                                member.name,
                                                                member.surname
                                                            )
                                                        "
                                                    >
                                                        {{ member.name }}
                                                        {{ member.surname }}
                                                    </li>
                                                </ul>
                                            </transition>
                                        </button>
                                    </div>
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
                                    <box-icon name="time"></box-icon>
                                </div>

                                <fieldset class="">
                                    <div
                                        class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left border p-1 rounded-lg border-dashed border-lime-500"
                                    >
                                        <input
                                            type="radio"
                                            value="1"
                                            class="h-4 w-4 border-gray-300 focus:ring-2 focus:ring-blue-300 cursor-pointer"
                                            aria-labelledby="country-option-1"
                                            aria-describedby="country-option-1"
                                            v-model="this.addData.code"
                                        />
                                        <label
                                            class="text-md font-medium text-gray-900 ml-2"
                                        >
                                            เวลาเข้า
                                        </label>
                                    </div>

                                    <div
                                        class="mt-3 text-center sm:mt-2 sm:ml-4 sm:text-left border p-1 rounded-lg border-dashed border-amber-500"
                                    >
                                        <input
                                            type="radio"
                                            value="2"
                                            class="h-4 w-4 border-gray-300 focus:ring-2 focus:ring-blue-300 cursor-pointer"
                                            aria-labelledby="country-option-2"
                                            aria-describedby="country-option-2"
                                            v-model="this.addData.code"
                                        />
                                        <label
                                            class="text-md font-medium text-gray-900 ml-2"
                                        >
                                            เวลาออก
                                        </label>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="sm:flex sm:items-start">
                                <transition name="fade" mode="out-in">
                                    <div
                                        v-if="this.addData.code === '1'"
                                        class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                    >
                                        <label
                                            id="listbox-label"
                                            class="block text-sm font-medium leading-6 text-gray-900"
                                            >เวลาเข้า :
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control block w-full px-3 py-1.5 rounded-lg text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-sky-300 focus:outline-none"
                                            placeholder="** 16:30:00 **"
                                            v-model="addData.timein"
                                        />
                                    </div>

                                    <div
                                        v-else
                                        class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                    >
                                        <label
                                            id="listbox-label"
                                            class="block text-sm font-medium leading-6 text-gray-900"
                                            >เวลากลับ :
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control block w-full px-3 py-1.5 rounded-lg text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-sky-300 focus:outline-none"
                                            placeholder="** 20:00:00 **"
                                            v-model="addData.timeout"
                                        />
                                    </div>
                                </transition>
                            </div>
                        </div>

                        <div
                            class="bg-white px-4 pb-4 sm:p-4 sm:pb-4"
                            :class="
                                this.addData.code === '1'
                                    ? 'grid grid-cols-2'
                                    : ''
                            "
                        >
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-lime-100 sm:mx-0 sm:h-10 sm:w-10"
                                >
                                    <box-icon
                                        name="message-square-dots"
                                    ></box-icon>
                                </div>
                                <transition name="fade" mode="out-in">
                                    <div
                                        v-if="this.addData.code === '1'"
                                        class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                    >
                                        <label
                                            id="listbox-label"
                                            class="block text-sm font-medium leading-6 text-gray-900"
                                            >จุดให้บริการ :
                                        </label>
                                        <div
                                            class="border-dotted border-2 rounded-lg p-2"
                                        >
                                            <button
                                                type="button"
                                                class="w-40 rounded-lg text-right"
                                                @click="
                                                    serviceShow = !serviceShow
                                                "
                                            >
                                                {{ this.myservice }}
                                                <box-icon
                                                    name="chevron-down"
                                                    size="xs"
                                                    class="hover:cursor-pointer"
                                                ></box-icon>

                                                <transition
                                                    name="fade"
                                                    mode="out-in"
                                                >
                                                    <ul
                                                        class="rounded-lg mt-4 p-2 overflow-hidden w-40 -mx-2 bg-white"
                                                        v-if="serviceShow"
                                                    >
                                                        <li
                                                            class="hover:bg-sky-400 hover:text-white rounded-lg"
                                                            v-for="(
                                                                service, index
                                                            ) in serviceList"
                                                            :key="index"
                                                            @click="
                                                                chooseService(
                                                                    service.id,
                                                                    service.title
                                                                )
                                                            "
                                                        >
                                                            {{ service.title }}
                                                        </li>
                                                    </ul>
                                                </transition>
                                            </button>
                                        </div>
                                    </div>

                                    <div
                                        v-else
                                        class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                    >
                                        <label
                                            id="listbox-label"
                                            class="block text-sm font-medium leading-6 text-gray-900"
                                            >หมายเหตุ :
                                        </label>
                                        <textarea
                                            class="border w-full rounded-lg p-2 focus:outline-none focus:ring-1 focus:border-blue-100"
                                            v-model="addData.otherout"
                                        ></textarea>
                                    </div>
                                </transition>
                            </div>
                        </div>

                        <transition name="fade" mode="out-in">
                            <div
                                v-if="showAlert"
                                class="text-red-400 text-center mb-2"
                            >
                                ** กรุณากรอกข้อมูลให้ครบถ้วน **
                            </div>
                        </transition>

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
                                @click="close()"
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
import Datepicker from "vue3-datepicker";
import moment from "moment";
import axios from "axios";
import html2canvas from "html2canvas";
import { jsPDF } from "jspdf";
import Swal from "sweetalert2";

export default {
    async mounted() {
        await this.search();
        this.getDep();
        // this.getTimer();
        await this.getService();
        this.getMember();
    },
    data() {
        return {
            logo: "/img/library.png",
            path: "/storage/img",
            picked: new Date(),
            show: true,
            modalEdit: false,
            modalAddTimeIn: false,
            report: {
                selected: "",
            },
            showDayList: "",
            depList: "",
            moment: moment,
            timer: "",
            editData: {
                id: "",
                name: "",
                surname: "",
                dat: "",
                otherout: "",
            },
            addData: {
                code: "",
                uid: "",
                name: "",
                surname: "",
                dat: "",
                timein: "",
                otherin: "",
                timeout: "",
                otherout: "",
            },
            // count: "",
            head: "",
            serviceList: "",
            memberList: "",
            showSelect: false,
            myname: "",
            serviceShow: false,
            myservice: "",
            showAlert: false,
        };
    },
    methods: {
        async search() {
            this.report.selected = moment(this.picked)
                // .subtract(1, "days")
                .format("YYYY-MM-DD");
            // console.log(this.selected)
            try {
                await this.$store.dispatch("reportDayOt", this.report);
                this.showDayList = this.$store.getters.reportDay;
                // this.count = this.showDayList[0]['count'];
                this.head = this.showDayList[0]["head"];
            } catch (err) {
                // console.log(err);
            }
        },
        getService() {
            axios
                .get("/api/service")
                .then((response) => {
                    this.serviceList = response.data;
                })
                .catch((err) => {
                    // console.log(err);
                });
        },
        showService(id) {
            var res = this.serviceList.filter(
                (selection) => selection["id"] == id
            );

            return res[0].title;
        },
        getDep() {
            axios
                .get("/api/dep")
                .then((response) => {
                    this.depList = response.data;
                })
                .catch((err) => {
                    // console.log(err);
                });
        },
        getMember() {
            axios
                .get("/api/otMember")
                .then((response) => {
                    this.memberList = response.data;
                    // console.log(this.memberList);
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        editOther(id, name, surname, dat, otherout) {
            this.editData.id = id;
            this.editData.name = name;
            this.editData.surname = surname;
            this.editData.dat = dat;
            this.editData.otherout = otherout;

            this.modalEdit = true;
        },
        closeEdit() {
            this.modalEdit = false;
        },
        async sendEdit() {
            try {
                await axios
                    .put("/api/editOt/" + this.editData.id, this.editData)
                    .then((response) => {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: response.data.message,
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        this.modalEdit = false;
                        this.search();
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            } catch (err) {
                console.log(err);
            }
        },
        addTime() {
            this.modalAddTimeIn = true;
        },
        close() {
            this.modalAddTimeIn = false;
        },
        async sendAdd() {
            this.showAlert = false;
            this.addData.dat = this.report.selected;

            if (this.addData.uid == "" || this.addData.code == "") {
                this.showAlert = true;
            } else if (this.addData.code == "1" && this.addData.timein == "") {
                this.showAlert = true;
            } else if (this.addData.code == "1" && this.addData.otherin == "") {
                this.showAlert = true;
            } else if (this.addData.code == "2" && this.addData.timeout == "") {
                this.showAlert = true;
            } else if (this.addData.code == "2" && this.addData.otherout == "") {
                this.showAlert = true;
            } else {
                try {
                    axios
                        .post("/api/addOt", this.addData)
                        .then((response) => {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: response.data.message,
                                showConfirmButton: false,
                                timer: 1500,
                            });
                            this.modalAddTimeIn = false;
                            this.search();
                        })
                        .catch((err) => {
                            console.log(err);
                        });
                } catch (err) {
                    console.log(err);
                }
            }
        },
        async printReport() {
            var dom = this.$refs.printRecord; //'tabalo' is an Id in my to-do list table
            html2canvas(dom).then(function (canvas) {
                var imgData = canvas.toDataURL("image/png");
                // var imgWidth = 210;
                // var pageHeight = 290;
                var imgWidth = 280;
                var pageHeight = 300;
                var imgHeight = (canvas.height * imgWidth) / canvas.width;
                var heightLeft = imgHeight;
                var doc = new jsPDF("l", "mm", "A4");
                var position = 10; // give some top padding to first page

                doc.addImage(imgData, "PNG", 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;

                while (heightLeft >= 0) {
                    position += heightLeft - imgHeight; // top padding for other pages
                    doc.addPage();
                    doc.addImage(
                        imgData,
                        "PNG",
                        0,
                        position,
                        imgWidth,
                        imgHeight
                    );
                    heightLeft -= pageHeight;
                }
                doc.save("file.pdf");
            });
        },
        showImg(y, m, d, pic) {
            window.open(
                "/storage/img/" + y + "/" + m + "/" + d + "/" + pic,
                "_blank"
            );
        },
        choose(id, name, surname) {
            this.addData.uid = id;
            this.addData.name = name;
            this.addData.surname = surname;
            this.myname = name + " " + surname;
        },
        chooseService(id, title) {
            this.addData.otherin = id;
            this.myservice = title;
        },
    },
    components: {
        Datepicker,

        myname() {
            return this.myname;
        },
        myservice() {
            return this.myservice;
        },
    },
};
</script>

<style>
.boxplus:hover {
    color: red;
}
</style>
