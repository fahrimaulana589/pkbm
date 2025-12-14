<?php

namespace App\Forms;

use App\Models\DataPpdb;
use App\Enums\DataPpdbType;
use Kris\LaravelFormBuilder\Form;

class PpdbRegistrationForm extends Form
{
    public function buildForm()
    {
        // Retrieve DataPpdb records for the current PPDB context
        // Assuming data is passed via options or we fetch global/active ones
        // For now, we'll assume the 'ppdb_id' is passed in options
        $ppdbId = $this->getData('ppdb_id');
        
        // Standard Fields
        $this->add('name', 'text', [
            'label' => 'Nama Lengkap',
            'rules' => 'required|string|max:255',
            'attr' => ['wire:model' => 'name', 'class' => 'form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent'],
            'wrapper' => ['class' => 'form-group mt-4'],
            'label_attr' => ['class' => 'block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1.5'],
        ]);

        $this->add('email', 'email', [
            'label' => 'Email',
            'rules' => 'required|email|max:255',
            'attr' => ['wire:model' => 'email', 'class' => 'form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent'],
            'wrapper' => ['class' => 'form-group mt-4'],
            'label_attr' => ['class' => 'block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1.5'],
        ]);

         $this->add('phone', 'text', [
            'label' => 'Nomor HP/WA',
            'rules' => 'required|string|max:20',
            'attr' => ['wire:model' => 'phone', 'class' => 'form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent'],
            'wrapper' => ['class' => 'form-group mt-4'],
            'label_attr' => ['class' => 'block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1.5'],
        ]);

        $this->add('address', 'textarea', [
            'label' => 'Alamat Lengkap',
            'rules' => 'required|string',
            'attr' => ['wire:model' => 'address', 'class' => 'form-textarea w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent'],
             'wrapper' => ['class' => 'form-group mt-4'],
            'label_attr' => ['class' => 'block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1.5'],
        ]);

        $this->add('birth_place', 'text', [
            'label' => 'Tempat Lahir',
            'rules' => 'required|string|max:255',
            'attr' => ['wire:model' => 'birth_place', 'class' => 'form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent'],
             'wrapper' => ['class' => 'form-group mt-4'],
            'label_attr' => ['class' => 'block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1.5'],
        ]);

        $this->add('birth_date', 'date', [
            'label' => 'Tanggal Lahir',
            'rules' => 'required|date',
            'attr' => ['wire:model' => 'birth_date', 'class' => 'form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent'],
             'wrapper' => ['class' => 'form-group mt-4'],
            'label_attr' => ['class' => 'block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1.5'],
        ]);

        
        $attributes = DataPpdb::where('ppdb_id', $ppdbId)
            ->where('status', '!=', 'inactive')
            ->get();

        foreach ($attributes as $attribute) {
            $this->addDynamicField($attribute);
        }
    }

    protected function addDynamicField(DataPpdb $attribute)
    {
        $key = \Illuminate\Support\Str::slug($attribute->nama, '_');
        $fieldName = 'extra_attributes.' . $key; // Bind to Livewire array
        $label = $attribute->nama;
        
        $rules = [];
        if ($attribute->status === 'active') {
            $rules[] = 'required';
        }
        // Add more type-specific validation rules if needed

        $options = [
            'label' => $label,
            'rules' => $rules,
            'attr' => [
                'wire:model' => $fieldName,
                'class' => 'form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent',
            ],
            'wrapper' => ['class' => 'form-group mt-4'],
             'label_attr' => ['class' => 'block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1.5'],
        ];

        if ($attribute->default) {
             // Handle default / description / placeholder
             $options['attr']['placeholder'] = $attribute->default;
        }

        $type = 'text'; // Default
        switch ($attribute->jenis) {
            case DataPpdbType::TEXT:
                $type = 'text';
                break;
            case DataPpdbType::NUMBER:
                $type = 'number';
                break;
            case DataPpdbType::DATE:
                $type = 'date';
                break;
            case DataPpdbType::TEXTAREA:
                $type = 'textarea';
                break;
             case DataPpdbType::FILE:
                $type = 'file';
                // For file uploads in Livewire, wire:model works differently, 
                // but basic binding is similar.
                break;
        }

        $this->add($attribute->nama, $type, $options); // Use attribute name as key
    }
}
