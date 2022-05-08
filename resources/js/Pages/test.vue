<template>
    <div>
        <Toast />
        <Toast position="top-left" group="tl" />
        <Toast position="bottom-left" group="bl" />
        <Toast position="bottom-right" group="br" />

        <Toast position="bottom-center" group="bc">
            <template #message="slotProps">
                <div class="flex flex-column">
                    <div class="text-center">
                        <i class="pi pi-exclamation-triangle" style="font-size: 3rem"></i>
                        <h4>{{slotProps.message.summary}}</h4>
                        <p>{{slotProps.message.detail}}</p>
                    </div>
                    <div class="grid p-fluid">
                        <div class="col-6">
                            <Button class="p-button-success" label="Yes" @click="onConfirm"></Button>
                        </div>
                        <div class="col-6">
                            <Button class="p-button-secondary" label="No" @click="onReject"></Button>
                        </div>
                    </div>
                </div>
            </template>
        </Toast>

        <div class="card">
            <h5>Severities</h5>
            <Button label="Success" class="p-button-success" @click="showSuccess" />
            <Button label="Info" class="p-button-info" @click="showInfo" />
            <Button label="Warn" class="p-button-warning" @click="showWarn" />
            <Button label="Error" class="p-button-danger" @click="showError" />

            <h5>Positions</h5>
            <Button label="Top Left" class="mr-2" @click="showTopLeft" />
            <Button label="Bottom Left" class="p-button-warning" @click="showBottomLeft" />
            <Button label="Bottom Right" class="p-button-success" @click="showBottomRight" />

            <h5>Options</h5>
            <Button @click="showMultiple" label="Multiple" class="p-button-warning" />
            <Button @click="showSticky" label="Sticky" />

            <h5>Remove All</h5>
            <Button @click="clear" label="Clear" />

            <h5>Template</h5>
            <Button @click="showTemplate" label="Confirm" />
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import { useToast } from "primevue/usetoast";
import Button from 'primevue/button';

export default {
    components: {'Button': Button},
    setup() {
        const toast = useToast();
       
        const showSuccess = () => {
            toast.add({severity:'success', summary: 'Success Message', detail:'Message Content', life: 3000});
        }
        const showInfo = () => {
            toast.add({severity:'info', summary: 'Info Message', detail:'Message Content', life: 3000});
        }
        const showWarn = () => {
            toast.add({severity:'warn', summary: 'Warn Message', detail:'Message Content', life: 3000});
        }
        const showError = () => {
            toast.add({severity:'error', summary: 'Error Message', detail:'Message Content', life: 3000});
        }
        const showTopLeft = () => {
            toast.add({severity: 'info', summary: 'Info Message', detail: 'Message Content', group: 'tl', life: 3000});
        }
        const showBottomLeft = () => {
            toast.add({severity:'warn', summary: 'Warn Message', detail:'Message Content', group: 'bl', life: 3000});
        }
        const showBottomRight = () => {
            toast.add({severity:'success', summary: 'Success Message', detail:'Message Content', group: 'br', life: 3000});
        }
        const showSticky = () => {
            toast.add({severity: 'info', summary: 'Sticky Message', detail: 'Message Content'});
        }
        const showMultiple = () => {
            toast.add({severity:'info', summary:'Message 1', detail:'Message 1 Content', life: 3000});
            toast.add({severity:'info', summary:'Message 2', detail:'Message 2 Content', life: 3000});
            toast.add({severity:'info', summary:'Message 3', detail:'Message 3 Content', life: 3000});
        }
        const showTemplate = () => {
            toast.add({severity: 'warn', summary: 'Are you sure?', detail: 'Proceed to confirm', group: 'bc'});
        }
        const onConfirm = () => {
            toast.removeGroup('bc');
        }
        const onReject = () => {
            toast.removeGroup('bc');
        }
        const clear = () => {
            toast.removeAllGroups();
        }

        return { showSuccess, showInfo, showWarn, showError, showTopLeft, showBottomLeft, 
            showBottomRight, showSticky, showMultiple, showTemplate, onConfirm, onReject, clear };
    }
};
</script>

<style scoped>
button {
    min-width: 10rem;
    margin-right: .5rem;
}

@media screen and (max-width: 960px) {
    button {
        width: 100%;
        margin-bottom: .5rem;
    }
}
</style>