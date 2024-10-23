<div>

    @auth
        @php
            $action = $this->getMountedAction();
        @endphp

        <x-filament::modal
            :heading="$action?->getModalHeading()"
            :id="$this->getId() . '-action'"
            :slide-over="$action?->isModalSlideOver()"
            :sticky-header="$action?->isModalHeaderSticky()"
            :width="$action?->getModalWidth()"
            :wire:key="$action ? $this->getId() . '.actions.' . $action->getName() . '.modal' : null"
            class="padding-0"
        >
            @if ($action)
                {{ $this->getMountedActionForm(mountedAction: $action) }}
            @endif
        </x-filament::modal>

        @php
            $this->hasActionsModalRendered = true;
        @endphp
    @endauth
        
    {{-- @php
        $action = auth()->user() ? $this->getMountedAction() : null;
    @endphp --}}

    {{-- <x-filament::modal
        :alignment="$action?->getModalAlignment()"
        :autofocus="$action?->isModalAutofocused()"
        :close-button="$action?->hasModalCloseButton()"
        :close-by-clicking-away="$action?->isModalClosedByClickingAway()"
        :close-by-escaping="$action?->isModalClosedByEscaping()"
        :description="$action?->getModalDescription()"
        display-classes="block"
        :extra-modal-window-attribute-bag="$action?->getExtraModalWindowAttributeBag()"
        :heading="$action?->getModalHeading()"
        :id="$this->getId() . '-action'"
        :slide-over="$action?->isModalSlideOver()"
        :sticky-footer="$action?->isModalFooterSticky()"
        :sticky-header="$action?->isModalHeaderSticky()"
        :width="$action?->getModalWidth()"
        :wire:key="$action ? $this->getId() . '.actions.' . $action->getName() . '.modal' : null"
        x-on:closed-form-component-action-modal.window="if (($event.detail.id === '{{ $this->getId() }}') && $wire.mountedActions.length) open()"
        x-on:modal-closed.stop="
            const mountedActionShouldOpenModal = {{ \Illuminate\Support\Js::from($action && $this->mountedActionShouldOpenModal(mountedAction: $action)) }}

            if (! mountedActionShouldOpenModal) {
                return
            }

            if ($wire.mountedFormComponentActions.length) {
                return
            }

            $wire.unmountAction(false)
        "
        x-on:opened-form-component-action-modal.window="if ($event.detail.id === '{{ $this->getId() }}') close()"
        class="padding-0"
    >
        @if ($action)
            {{ $action->getModalContent() }}
        @endif

        @if ($this->mountedActionHasForm(mountedAction: $action))
            {{ $this->getMountedActionForm() }}
        @endif
    </x-filament::modal> --}}
</div>