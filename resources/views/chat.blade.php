@extends('layouts.app')
@section('content')

<background posturl="{{ url("/api/") }}" inline-template>
	<div id="particles-js" class="background" v-bind:class="[mood]">
		<div class="modal is-active">
		  <div class="modal-content">
		    <article class="message">
			  <div class="message-header">
			    <p>Phil the AI</p>
			  </div>
			  <div class="message-body">
				  <div class="box">
					  <h1 class="box-title">
						  Chatt
					  </h1>

					  <div class="chat">
						  <div class="chat-box" id="chat-box">
							  <div class="message-container" v-for="(message, key) in messages" v-cloak>
								  <div class="message">
									  @{{ message.message }}
								  </div>
                                  <div class="message from-user">
                                      @{{ message.response }}
                                  </div>
							  </div>
						  </div>
						  <div class="input-box">
							  <p class="control has-addons chat-control">
								  <input type="text" v-model="message" class="input is-expanded" autofocus v-on:keyup.enter="post">
								  <button class="button is-primary" v-on:click="post">Skicka</button>
							  </p>
						  </div>
                          <audio autoplay="true" ref="audio" v-bind:src="audio">
					  </div>
				  </div>
			  </div>
			</article>
		  </div>
		</div>
	</div>
</background>

@stop