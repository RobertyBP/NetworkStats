$.extend($.validator.messages, {
    required: "Este campo é obrigatório.",
    email: "Forneça um endereço de e-mail válido.",
    minlength: $.validator.format("Insira pelo menos {0} caracteres."),
    maxlength: $.validator.format("Insira no máximo {0} caracteres."),
	integer: "Forneça um número válido.",
    customrule: "Insira um e-mail válido ou um número de ramal.",
});
