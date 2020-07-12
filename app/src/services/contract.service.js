import ApiService from './api.service'

class ContractService extends ApiService {
  constructor () {
    super({ segment: 'contracts' })
  }

  store(data) {
    return this.client.post('', data);
  }
  
}

export default new ContractService()
