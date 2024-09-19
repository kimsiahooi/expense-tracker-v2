<template>
  <section class="min-h-screen py-5">
    <div class="container mx-auto">
      <div class="text-end mb-5">
        <Button @click="createHandler"> Create </Button>
      </div>
      <Card>
        <CardHeader>
          <CardTitle>Transaction List</CardTitle>
        </CardHeader>
        <CardContent>
          <Table class="min-w-max">
            <TableCaption>A list of your recent transactions.</TableCaption>
            <TableHeader>
              <TableRow>
                <TableHead>ID</TableHead>
                <TableHead>Name</TableHead>
                <TableHead>Amount</TableHead>
                <TableHead>Transaction At</TableHead>
                <TableHead>Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-for="transaction in transactions" :key="transaction.id">
                <TableCell class="w-max">{{ transaction.id }}</TableCell>
                <TableCell class="w-max">{{ transaction.name }}</TableCell>
                <TableCell class="w-max">RM{{ transaction.amount }}</TableCell>
                <TableCell class="w-max">{{ format(transaction.transaction_at, 'MMMM dd, yyyy') }}</TableCell>
                <TableCell class="w-max">
                  <TooltipProvider>
                    <div class="space-x-5">
                      <Tooltip>
                        <TooltipTrigger>
                          <Pencil class="w-4 h-4" @click="editHandler(transaction)" />
                        </TooltipTrigger>
                        <TooltipContent>
                          <p>Edit</p>
                        </TooltipContent>
                      </Tooltip>
                      <Tooltip>
                        <TooltipTrigger>
                          <Trash2 class="w-4 h-4 text-destructive" @click="deleteHandler(transaction)" />
                        </TooltipTrigger>
                        <TooltipContent>
                          <p>Delete</p>
                        </TooltipContent>
                      </Tooltip>
                    </div>
                  </TooltipProvider>
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>
        </CardContent>
      </Card>
    </div>
  </section>
  <Dialog v-model:open="dialogForm.createModalIsOpen">
    <DialogContent>
      <DialogHeader>
        <DialogTitle>Create Transaction</DialogTitle>
        <DialogDescription class="mt-2">
          <form @submit.prevent="submitCreateHandler">
            <div class="mb-5 space-y-5">
              <div>
                <label class="mb-2 block text-black" for="name">Name</label>
                <Input
                  class="text-black"
                  :class="{
                    'border-destructive': createForm.errors.name,
                  }"
                  type="text"
                  placeholder="Food etc.."
                  v-model="createForm.name" />
                <p v-if="createForm.errors.name" class="text-destructive">{{ createForm.errors.name }}</p>
              </div>
              <div>
                <label class="mb-2 block text-black" for="name">Amount</label>
                <Input
                  class="text-black"
                  :class="{
                    'border-destructive': createForm.errors.amount,
                  }"
                  type="number"
                  v-model.number="createForm.amount"
                  step="0.01" />
                <p v-if="createForm.errors.amount" class="text-destructive">
                  {{ createForm.errors.amount }}
                </p>
              </div>
              <div>
                <label class="mb-2 block text-black" for="transaction_at">Transaction Date</label>
                <Input
                  class="text-black"
                  :class="{
                    'border-destructive': createForm.errors.transaction_at,
                  }"
                  type="date"
                  placeholder="Select A Date"
                  :max="format(new Date(), 'yyyy-MM-dd')"
                  v-model="createForm.transaction_at" />
                <p v-if="createForm.errors.transaction_at" class="text-destructive">
                  {{ createForm.errors.transaction_at }}
                </p>
              </div>
            </div>
            <Button type="submit" :disabled="createForm.processing">
              <Loader2
                class="w-4 h-4 mr-2 animate-spin"
                :class="{
                  hidden: !createForm.processing,
                }" />
              Submit
            </Button>
          </form>
        </DialogDescription>
      </DialogHeader>
    </DialogContent>
  </Dialog>
  <Dialog v-model:open="dialogForm.editModalIsOpen">
    <DialogContent>
      <DialogHeader>
        <DialogTitle>Edit Transaction</DialogTitle>
        <DialogDescription class="mt-2">
          <form @submit.prevent="submitEditHandler">
            <div class="mb-5 space-y-5">
              <div>
                <label class="mb-2 block text-black" for="name">Name</label>
                <Input
                  class="text-black"
                  :class="{
                    'border-destructive': editForm.errors.name,
                  }"
                  type="text"
                  placeholder="Food etc.."
                  v-model="editForm.name" />
                <p v-if="editForm.errors.name" class="text-destructive">{{ editForm.errors.name }}</p>
              </div>
              <div>
                <label class="mb-2 block text-black" for="name">Amount</label>
                <Input
                  class="text-black"
                  :class="{
                    'border-destructive': editForm.errors.amount,
                  }"
                  type="number"
                  v-model.number="editForm.amount"
                  step="0.01" />
                <p v-if="editForm.errors.amount" class="text-destructive">
                  {{ editForm.errors.amount }}
                </p>
              </div>
              <div>
                <label class="mb-2 block text-black" for="transaction_at">Transaction Date</label>
                <Input
                  class="text-black"
                  :class="{
                    'border-destructive': editForm.errors.transaction_at,
                  }"
                  type="date"
                  placeholder="Select A Date"
                  :max="format(new Date(), 'yyyy-MM-dd')"
                  v-model="editForm.transaction_at" />
                <p v-if="editForm.errors.transaction_at" class="text-destructive">
                  {{ editForm.errors.transaction_at }}
                </p>
              </div>
            </div>
            <Button type="submit" :disabled="editForm.processing">
              <Loader2
                class="w-4 h-4 mr-2 animate-spin"
                :class="{
                  hidden: !editForm.processing,
                }" />
              Submit
            </Button>
          </form>
        </DialogDescription>
      </DialogHeader>
    </DialogContent>
  </Dialog>
  <AlertDialog v-model:open="dialogForm.deleteModalIsOpen">
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
        <AlertDialogDescription>
          This action cannot be undone. This will permanently delete your transaction record from our servers.
        </AlertDialogDescription>
      </AlertDialogHeader>
      <AlertDialogFooter>
        <AlertDialogCancel>Cancel</AlertDialogCancel>
        <Button @click="submitDeleteHandler">Continue</Button>
      </AlertDialogFooter>
    </AlertDialogContent>
  </AlertDialog>
</template>

<script setup>
import { reactive } from 'vue'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { Loader2, Pencil, Trash2 } from 'lucide-vue-next'
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip'
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog'
import { Input } from '@/components/ui/input'
import { format } from 'date-fns'
import { router, useForm } from '@inertiajs/vue3'
import {
  AlertDialog,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
} from '@/components/ui/alert-dialog'
import { useToast } from 'primevue/usetoast'

const toast = useToast()

defineProps({
  transactions: Array,
})

const createForm = useForm({
  name: '',
  amount: 0,
  transaction_at: format(new Date(), 'yyyy-MM-dd'),
})

const editForm = useForm({
  name: '',
  amount: 0,
  transaction_at: format(new Date(), 'yyyy-MM-dd'),
})

const dialogForm = reactive({
  currentEditId: 1,
  currentDeleteId: 1,
  createModalIsOpen: false,
  editModalIsOpen: false,
  deleteModalIsOpen: false,
})

const createHandler = () => {
  dialogForm.createModalIsOpen = true
}

const submitCreateHandler = () => {
  createForm.post('/transactions', {
    onSuccess: ({
      props: {
        flash: { message },
      },
    }) => {
      if (message) {
        dialogForm.createModalIsOpen = false

        toast.add({
          severity: message.variant || 'info',
          summary: message.title,
          detail: message.description,
          life: 3000,
        })
      }
    },
  })
}

const editHandler = (transaction) => {
  editForm.name = transaction.name
  editForm.amount = transaction.amount
  editForm.transaction_at = format(transaction.transaction_at, 'yyyy-MM-dd')
  dialogForm.currentEditId = transaction.id
  dialogForm.editModalIsOpen = true
}

const submitEditHandler = () => {
  editForm.put(`/transactions/${dialogForm.currentEditId}`, {
    onSuccess: ({
      props: {
        flash: { message },
      },
    }) => {
      if (message) {
        dialogForm.editModalIsOpen = false

        toast.add({
          severity: message.variant || 'info',
          summary: message.title,
          detail: message.description,
          life: 3000,
        })
      }
    },
  })
}

const deleteHandler = (transaction) => {
  dialogForm.currentDeleteId = transaction.id
  dialogForm.deleteModalIsOpen = true
}

const submitDeleteHandler = () => {
  router.delete(`/transactions/${dialogForm.currentDeleteId}`, {
    onSuccess: ({
      props: {
        flash: { message },
      },
    }) => {
      if (message) {
        dialogForm.deleteModalIsOpen = false

        toast.add({
          severity: message.variant || 'info',
          summary: message.title,
          detail: message.description,
          // life: 3000,
        })
      }
    },
  })
}
</script>
