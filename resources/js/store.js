import {createStore} from 'vuex';
import axios from 'axios';


// Create a new store instance.
const store = createStore({
                            // Deklarieren von Variabeln
                              state() {
                                  return {
                                      constants: {},
                                  }
                              },
                            // Definieren von functions()
                              mutations: {
                                  setConstants(state, constants) {
                                      state.constants = constants;
                                  }
                              },
                            // Ausführen von Logik und Deklarieren von Variablen
                              actions: {
                                  fetchConstants({ commit }) {
                                      axios.get('/api/constants').then((response) => {
                                          const constants = response.data;
                                          commit('setConstants', constants);
                                      })
                                          .catch((error) => {
                                              console.error('Error fetching constants: ', error);
                                          });
                                  }
                              }
                          });
export default store;