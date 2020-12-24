<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
                >
                    <p class="_title0">
                        Tags
                        <Button
                            type="success"
                            size="small"
                            @click="addModal = true"
                            ><Icon type="md-add" /> Add tag</Button
                        >
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Tag Name</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr
                                v-for="(tag, i) in tags"
                                :key="i"
                                v-if="tags.length"
                            >
                                <td>{{ tag.id }}</td>
                                <td class="_table_name">
                                    {{ tag.tagName }}
                                </td>
                                <td>{{ tag.created_at }}</td>
                                <td>
                                    <Button
                                        type="warning"
                                        size="small"
                                        @click="showEditModal(tag)"
                                        >Edit</Button
                                    >
                                    <Button
                                        type="error"
                                        size="small"
                                        @click="showDeleteModal(tag)"
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
                    title="Add tag"
                    :mask-closable="false"
                >
                    <Input
                        v-model="data.tagName"
                        placeholder="Enter tag name"
                    />

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
                            @click="addTag"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{ isAdding ? "Submitting.." : "Submit" }}</Button
                        >
                    </div>
                </Modal>

                <!-- Tag editing modal -->
                <Modal
                    v-model="editModal"
                    title="Edit tag"
                    :mask-closable="false"
                >
                    <Input
                        v-model="editData.tagName"
                        placeholder="Enter tag name"
                    />

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
                            @click="editTag"
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
                        <Input
                            v-model="editData.id"
							disabled
                        >
						<span slot="prepend">Tag Id</span>
						</Input>
						<br>
                        <Input
                            v-model="editData.tagName"
							disabled
                        >
						<span slot="prepend">Tag Name</span>
						</Input>
						
                        
                    </div>
                    <div style="text-align:center">
                        <p>Are you sure, you want to delete it?</p>
                    </div>
                    <div slot="footer">
                        <Button
                            type="error"
                            size="large"
							long
                            @click="deleteTag(editData.id)"
							:disabled="isLoading"
                            :loading="isLoading"
                            >{{isLoading ? 'Deleting...' : 'Delete'}}</Button
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
                tagName: ""
            },
            editData: {
                id: "",
                tagName: ""
            },
            addModal: false,
            editModal: false,
            deleteModal: false,
            isAdding: false,
            isLoading: false,
            tags: []
        };
    },
    methods: {
        async addTag() {
            if (this.data.tagName.trim() == "") {
                return this.error("Tag Name is required", "Ooops");
            }

            this.isAdding = true;
            const res = await this.callApi("post", "app/create_tag", this.data);

            if (res.status == 201) {
                this.tags.unshift(res.data);
                this.success("Tag has been added successfully!");
                this.addModal = false;
            } else {
                this.addModal = false;

                if (res.status == 422) {
                    if (res.data.errors.tagName) {
                        this.genError(res.data.errors.tagName[0]);
                    }
                } else {
                    this.genError();
                }
            }
            this.clearData();
            this.isAdding = false;
        },
        async editTag() {
            if (this.editData.tagName.trim() == "") {
                return this.error("Tag Name is required", "Ooops");
            }

            this.isAdding = true;
            const res = await this.callApi(
                "put",
                "app/edit_tag",
                this.editData
            );

            if (res.status == 200) {
                this.tags = res.data;
                this.success("Tag has been updated successfully!");
                this.editModal = false;
            } else {
                this.editModal = false;

                if (res.status == 422) {
                    if (res.data.errors.tagName) {
                        this.genError(res.data.errors.tagName[0]);
                    }
                } else {
                    this.genError();
                }
            }
            this.clearData();
            this.isAdding = false;
        },
        showEditModal(tag) {
            let tagObj = {
                id: tag.id,
                tagName: tag.tagName
            };
            this.editData = tagObj;
            this.editModal = true;
        },
        async deleteTag(id) {
			this.isLoading = true

			const res = await this.callApi(
                "delete",
                "app/delete_tag",
                this.editData
			);
			
			if (res.status == 200) {
                this.tags = res.data;
                this.success("Tag has been deleted successfully!");
                this.editModal = false;
            } else {
                this.editModal = false;

                if (res.status == 422) {
                    if (res.data.errors.tagName) {
                        this.genError(res.data.errors.tagName[0]);
                    }
                } else {
                    this.genError();
                }
			}
			
			this.isLoading = false;
			this.deleteModal = false;
		},
        showDeleteModal(tag) {
            this.deleteModal = true;
            let tagObj = {
                id: tag.id,
                tagName: tag.tagName
            };
            this.editData = tagObj;
        },
        clearData() {
            this.data.tagName = "";
        }
    },
    async created() {
        const res = await this.callApi("get", "app/get_tags");

        if (res.status == 200) {
            this.tags = res.data;
        } else {
            this.genError();
        }
    }
};
</script>
