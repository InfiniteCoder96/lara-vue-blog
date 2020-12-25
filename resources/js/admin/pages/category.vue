<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
                >
                    <p class="_title0">
                        Categories
                        <Button
                            type="success"
                            size="small"
                            @click="addModal = true"
                            ><Icon type="md-add" /> Add category</Button
                        >
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Category Image</th>
                                <th>Category Name</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr
                                v-for="(category, i) in categories"
                                :key="i"
                                v-if="categories.length"
                            >
                                <td>{{ category.id }}</td>
                                <td>
                                    <div
                                        class="category-image"
                                        v-if="category.iconImage"
                                    >
                                        <template>
                                            <img :src="category.iconImage" />
                                        </template>
                                    </div>
                                    
                                </td>
                                <td class="_table_name">
                                    {{ category.categoryName }}
                                </td>
                                <td>{{ category.created_at }}</td>
                                <td>
                                    <Button
                                        type="warning"
                                        size="small"
                                        @click="showEditModal(category)"
                                        >Edit</Button
                                    >
                                    <Button
                                        type="error"
                                        size="small"
                                        @click="showDeleteModal(category)"
                                        >Delete</Button
                                    >
                                </td>
                            </tr>
                            <!-- ITEMS -->
                        </table>
                    </div>
                </div>

                <!-- Tag adding modal -->
                <Modal
                    v-model="addModal"
                    title="Add Category"
                    :mask-closable="false"
                >
                    <Input
                        v-model="data.categoryName"
                        placeholder="Enter category name"
                    />
                    <br /><br />

                    <div class="demo-upload-list" v-if="data.iconImage">
                        <template>
                            <img
                                :src="`/uploads/categories/${data.iconImage}`"
                            />
                            <div class="demo-upload-list-cover">
                                <Icon
                                    type="ios-trash-outline"
                                    @click.native="handleRemove()"
                                ></Icon>
                            </div>
                        </template>
                    </div>

                    <Upload
                        ref="upload"
                        :on-success="handleSuccess"
                        :format="['jpg', 'jpeg', 'png']"
                        :max-size="2048"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                        :before-upload="handleBeforeUpload"
                        :on-error="handleError"
                        type="drag"
                        action="/app/upload_category_icon"
                        :headers="{
                            'x-csrf-token': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        }"
                        style="display: inline-block;width:50%;"
                    >
                        <div style="padding: 20px 0">
                            <Icon
                                type="ios-cloud-upload"
                                size="52"
                                style="color: #3399ff"
                            ></Icon>
                            <p>Click or drag files here to upload</p>
                        </div>
                    </Upload>

                    <div slot="footer">
                        <Button
                            type="default"
                            size="small"
                            @click="addModal = false"
                            >Close</Button
                        >
                        <Button
                            type="success"
                            size="small"
                            @click="addCategory"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{ isAdding ? "Submitting.." : "Submit" }}</Button
                        >
                    </div>
                </Modal>

                <!-- Tag editing modal -->
                <Modal
                    v-model="editModal"
                    title="Edit category"
                    :mask-closable="false"
                >
                    <Input
                        v-model="editData.categoryName"
                        placeholder="Enter category name"
                    />
                    <br/><br/>

                    <div class="demo-upload-list" v-if="editData.iconImage">
                        <template>
                            <img :src="editData.iconImage"/>
                            <div class="demo-upload-list-cover">
                                <Icon
                                    type="ios-trash-outline"
                                    @click.native="handleRemove(true)"
                                ></Icon>
                            </div>
                        </template>
                    </div>

                    <Upload
                        ref="editUpload"
                        :on-success="handleEditSuccess"
                        :format="['jpg', 'jpeg', 'png']"
                        :max-size="2048"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                        :before-upload="handleBeforeUpload"
                        :on-error="handleError"
                        type="drag"
                        action="/app/upload_category_icon"
                        :headers="{
                            'x-csrf-token': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        }"
                        style="display: inline-block;width:50%;"
                    >
                        <div style="padding: 20px 0">
                            <Icon
                                type="ios-cloud-upload"
                                size="52"
                                style="color: #3399ff"
                            ></Icon>
                            <p>Click or drag files here to upload</p>
                        </div>
                    </Upload>

                    <div slot="footer">
                        <Button
                            type="default"
                            size="small"
                            @click="editModal = false"
                            >Close</Button
                        >
                        <Button
                            type="success"
                            size="small"
                            @click="editCategory"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{ isAdding ? "Editing..." : "Submit" }}</Button
                        >
                    </div>
                </Modal>

                <!-- Tag delete confirmation modal -->
                <Modal v-model="deleteModal">
                    <p slot="header" style="color:#f60;text-align:center">
                        <Icon type="ios-information-circle"></Icon>
                        <span>Delete confirmation</span>
                    </p>
                    <div style="text-align:left">
                        <Input v-model="editData.id" disabled>
                            <span slot="prepend">Category Id</span>
                        </Input>
                        <br/>
                        <Input v-model="editData.categoryName" disabled>
                            <span slot="prepend">Category Name</span>
                        </Input>
                        <br/>
                        <div
                                        class="category-image"
                                        v-if="editData.iconImage"
                                    >
                                        <template>
                                            <img :src="editData.iconImage" />
                                        </template>
                                    </div>
                        <br/>
                    </div>
                    <div style="text-align:center">
                        <p>Are you sure, you want to delete it?</p>
                    </div>
                    <div slot="footer">
                        <Button
                            type="error"
                            size="large"
                            long
                            @click="deleteCategory(editData.id)"
                            :disabled="isLoading"
                            :loading="isLoading"
                            >{{ isLoading ? "Deleting..." : "Delete" }}</Button
                        >
                    </div>
                </Modal>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            data: {
                iconImage: "",
                categoryName: ""
            },
            editData: {
                id: "",
                iconImage: "",
                categoryName: ""
            },
            addModal: false,
            editModal: false,
            deleteModal: false,
            isAdding: false,
            isLoading: false,
            categories: [],
            token: "",
            image: []
        };
    },
    methods: {
        async handleRemove(isEdit=false) {
            let file = ''
            if(isEdit){
                var n = this.editData.iconImage.lastIndexOf('/');
                var result = this.editData.iconImage.substring(n + 1);
                file = result;
                this.editData.iconImage = "";
                this.$refs.editUpload.clearFiles();
            }else{
                file = this.data.iconImage;
                this.data.iconImage = "";
                this.$refs.upload.clearFiles();
            }
                        
            const res = await this.callApi(
                "post",
                "app/delete_category_image",
                {imageName: file}
            );

            if (res.status !== 200) {
                this.data.iconImage = file;
                this.genError();
            }
        },
        handleSuccess(res, file) {
            this.data.iconImage = res;
            this.image = [
                {
                    url: res,
                    name: res
                }
            ];
        },
        handleEditSuccess(res, file) {
            this.editData.iconImage = `/uploads/categories/${res}`;
        },
        handleFormatError(file) {
            this.$Notice.warning({
                title: "The file format is incorrect",
                desc:
                    "File format of " +
                    file.name +
                    " is incorrect, please select jpg or png."
            });
        },
        handleMaxSize(file) {
            this.$Notice.warning({
                title: "Exceeding file size limit",
                desc: "File  " + file.name + " is too large, no more than 2M."
            });
        },
        handleBeforeUpload() {
            const check = this.image.length < 5;
            if (!check) {
                this.$Notice.warning({
                    title: "Up to five pictures can be uploaded."
                });
            }
            return check;
        },
        handleError(res, file) {
            this.genError(file.errors.file[0]);
        },
        async addCategory() {
            if (this.data.iconImage.trim() == "")
                return this.error("Category Image is required", "Oops");
            if (this.data.categoryName.trim() == "")
                return this.error("Category Name is required", "Oops");

            this.data.iconImage = `/uploads/categories/${this.data.iconImage}`;

            this.isAdding = true;
            const res = await this.callApi(
                "post",
                "app/create_category",
                this.data
            );

            if (res.status == 201) {
                this.categories.unshift(res.data);
                this.success("Category has been added successfully!");
                this.addModal = false;
            } else {
                this.addModal = false;

                if (res.status == 422) {
                    if (res.data.errors.categoryName) {
                        this.genError(res.data.errors.categoryName[0]);
                    }
                    if (res.data.errors.iconImage) {
                        this.genError(res.data.errors.iconImage[0]);
                    }
                } else {
                    this.genError();
                }
            }
            this.clearData();
            this.isAdding = false;
        },
        async editCategory() {
            if (this.editData.iconImage.trim() == "")
                return this.error("Category Image is required", "Oops");
            if (this.editData.categoryName.trim() == "")
                return this.error("Category Name is required", "Oops");

            //this.editData.iconImage = `/uploads/categories/${this.editData.iconImage}`;

            this.isAdding = true;

            const res = await this.callApi(
                "put",
                "app/edit_category",
                this.editData
            );

            if (res.status == 200) {
                this.categories = res.data;
                this.success("Category has been updated successfully!");
                this.editModal = false;
            } else {
                this.editModal = false;

                if (res.status == 422) {
                    if (res.data.errors.categoryName) {
                        this.genError(res.data.errors.categoryName[0]);
                    }
                } else {
                    this.genError();
                }
            }
            this.clearData();
            this.isAdding = false;
        },
        showEditModal(category) {
            let categoryObj = {
                id: category.id,
                iconImage: category.iconImage,
                categoryName: category.categoryName
            };
            this.editData = categoryObj;
            this.editModal = true;
        },
        async deleteCategory(id) {
            this.isLoading = true;

            const res = await this.callApi(
                "delete",
                "app/delete_category",
                this.editData
            );

            if (res.status == 200) {
                this.categories = res.data;
                this.success("Category has been deleted successfully!");
                this.editModal = false;
            } else {
                this.editModal = false;

                if (res.status == 422) {
                    if (res.data.errors.categoryName) {
                        this.genError(res.data.errors.categoryName[0]);
                    }
                } else {
                    this.genError();
                }
            }

            this.isLoading = false;
            this.deleteModal = false;
        },
        showDeleteModal(category) {
            this.deleteModal = true;
            let categoryObj = {
                id: category.id,
                categoryName: category.categoryName,
                iconImage: category.iconImage
            };
            this.editData = categoryObj;
        },
        clearData() {
            this.data.categoryName = "";
            this.data.iconImage = "";
            this.$refs.upload.clearFiles();
            this.$refs.editUpload.clearFiles();
        }
    },
    async created() {
        this.token = window.Laravel.csrfToken;
        const res = await this.callApi("get", "app/get_categories");

        if (res.status == 200) {
            this.categories = res.data;
        } else {
            this.genError();
        }
    }
};
</script>

