@extends('layouts.app')
@section('content')

<background inline-template>
	<div id="particles-js" class="background" v-bind:class="[mood]">
		<div class="modal is-active">
		  <div class="modal-content">
		    <article class="message">
			  <div class="message-header">
			    <p>Phil the AI</p>
			  </div>
			  <div class="message-body">
			    <div class="chat-box"></div>
			    <input class="input" type="text" v-on:keyup.enter="read" v-model="message">
			  </div>
			</article>
		  </div>
		</div>
	</div>
</background>

@stop