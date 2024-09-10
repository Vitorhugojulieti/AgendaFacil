
const mp = new MercadoPago('TEST-12821cac-d4b6-449a-9e11-930e17c63b82');
const bricksBuilder = mp.bricks();


const renderPaymentBrick = async (bricksBuilder) => {
  const settings = {
    initialization: {
      /*
       "amount" é o valor total a ser pago por todos os meios de pagamento
     com exceção da Conta Mercado Pago e Parcelamento sem cartão de crédito, que tem seu valor de processamento determinado no backend através do "preferenceId"
      */
      amount: 100,
    },
    customization: {
      paymentMethods: {
        ticket: "all",
        bankTransfer: "all",
        creditCard: "all",
        debitCard: "all",
        mercadoPago: "all",
      },
    },
    callbacks: {
      onReady: () => {
        /*
         Callback chamado quando o Brick estiver pronto.
         Aqui você pode ocultar loadings do seu site, por exemplo.
        */
      },
      onSubmit: ({ selectedPaymentMethod, formData }) => {
        // callback chamado ao clicar no botão de submissão dos dados
        return new Promise((resolve, reject) => {
          fetch("/schedule/paymentSchedule", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify(formData),
          })
            .then((response) => response.json())
            .then((response) => {
              // receber o resultado do pagamento

              
              const renderStatusScreenBrick = async (bricksBuilder) => {
                const settings = {
                  initialization: {
                    paymentId: response.id, // id do pagamento a ser mostrado
                  },
                  callbacks: {
                    onReady: () => {
                      /*
                        Callback chamado quando o Brick estiver pronto.
                        Aqui você pode ocultar loadings do seu site, por exemplo.
                      */
                    },
                    onError: (error) => {
                      // callback chamado para todos os casos de erro do Brick
                      console.error(error);
                    },
                  },
                };
                window.statusScreenBrickController = await bricksBuilder.create(
                  'statusScreen',
                  'statusScreenBrick_container',
                  settings,
                );  
              };
              renderStatusScreenBrick(bricksBuilder);

 
              resolve();
            })
            .catch((error) => {
              // lidar com a resposta de erro ao tentar criar o pagamento
              reject();
            });
        });
      },
      onError: (error) => {
        // callback chamado para todos os casos de erro do Brick
        console.error(error);
      },
    },
  };
  window.paymentBrickController = await bricksBuilder.create(
    "payment",
    "paymentBrick_container",
    settings
  );
 };
 renderPaymentBrick(bricksBuilder);
 